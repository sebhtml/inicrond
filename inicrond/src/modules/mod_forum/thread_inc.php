<?php
/*
    $Id$

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005  Sébastien Boisvert

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include "includes/functions/access.php";
include "includes/functions/conversion.inc.php";
include "includes/functions/parent_view_count_for_post.php";

include "includes/functions/order_posts_in_thread.php";

/*
    view the thread
*/

if(isset($_GET["forum_sujet_id"]) && $_GET["forum_sujet_id"] != ""
&& (int) $_GET["forum_sujet_id"]
&& can_usr_view_forum($_SESSION['usr_id'], sujet_2_discussion($_GET["forum_sujet_id"])))
{
    $cours_id = forum_to_cours(sujet_2_discussion($_GET["forum_sujet_id"]) );

    $query = "
    INSERT
    INTO
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['views_of_threads']."
    (usr_id, forum_sujet_id, gmt_timestamp)
    VALUES
    (".$_SESSION['usr_id'].", ".$_GET["forum_sujet_id"].", ".inicrond_mktime().")
    ";

    $inicrond_db->Execute($query);

    $query = "
    SELECT
    forum_discussion_name, ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id=".$_GET["forum_sujet_id"]."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $forum_discussion_id = $fetch_result["forum_discussion_id"] ;
    $forum_discussion_name = $fetch_result["forum_discussion_name"] ;

    //-----------------------
    // titre
    //---------------------

    $module_title = $_LANG['thread'];

    if($_OPTIONS['smarty_cache_config']['mod_forum']["thread.tpl"] != 0)// != 0
    {
        $smarty->caching = 1;
        $smarty->cache_lifetime = $_OPTIONS['smarty_cache_config']['mod_forum']["thread.tpl"];
    }

    $cache_id = md5($_SESSION['language'].$_GET["forum_sujet_id"].$_SESSION['usr_id']) ;

    if(!$smarty->is_cached($_OPTIONS['theme']."/thread.tpl", $cache_id))
    {
        if(peut_il_replier($_SESSION['usr_id'], $_GET["forum_sujet_id"]))//peut-il replier ?
        {
            $can_reply = TRUE;
        }

        if(is_mod($_SESSION['usr_id'], $forum_discussion_id)) //moderateur seulement
        {
            $smarty->assign('move_thread_link', "move_a_thread.php?forum_sujet_id=".$_GET["forum_sujet_id"]);

            $smarty->assign('lock_thread_link', "lock_or_unlock_a_thread.php?forum_sujet_id=".$_GET["forum_sujet_id"]);
        }

        //--------------------
        //affiche la liste des massage dune belle mani�e
        //---------------------

        $query = "
        SELECT
        forum_message_id,
        forum_message_titre, forum_message_contenu, forum_message_id,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id, ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_name,  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_signature,
        forum_message_add_gmt_timestamp, forum_message_edit_gmt_timestamp,
        forum_message_id_reply_to,
        usr_nom,
        usr_prenom
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        forum_sujet_id=".$_GET["forum_sujet_id"]."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".usr_id
        ";

        $posts = array();

        $i = 0 ;

        $reply = peut_il_replier($_SESSION['usr_id'], $_GET["forum_sujet_id"]);

        $rs = $inicrond_db->Execute($query);

        while ($fetch_result = $rs->FetchRow ())
        {
            $posts[$i]["forum_message_id"] =  $fetch_result["forum_message_id"];

            $posts[$i]["post_anchor"] = "<a name=".$fetch_result["forum_message_id"]."></a>";//ancre.

            $posts[$i]["post_title"] =  $fetch_result["forum_message_titre"];

            if($reply)
            {
                $posts[$i]["reply_link"] = "reply.php?forum_message_id=".$fetch_result["forum_message_id"];//replier
            }

            $posts[$i]["forum_message_id_reply_to"] =  $fetch_result["forum_message_id_reply_to"];
            $posts[$i]["forum_sujet_id"] =  $_GET["forum_sujet_id"];

            $posts[$i]["the_great_space_ship_commander"] = parent_view_count_for_post($fetch_result["forum_message_id"]);

            if($_SESSION['usr_id'] == $fetch_result['usr_id'])//éditer
            {
                $posts[$i]["edit_link"] =  retournerHref("edit_post.php?forum_message_id=".
                $fetch_result["forum_message_id"], $_LANG['edit']);
            }

            $posts[$i]['usr_picture'] = "<img src=\"../../modules/members/download.php?&usr_id=".$fetch_result['usr_id']."\"/>";

            $posts[$i]["usr_link"] = retournerHref("".__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result['usr_id'],
            $fetch_result['usr_name']." (".$fetch_result['usr_prenom']." ".$fetch_result['usr_nom'].")");

            //---------------
            //informations temporels
            //---------------

            $posts[$i]["post_add_time"] = $_LANG['add_gmt']." : ".
            format_time_stamp($fetch_result["forum_message_add_gmt_timestamp"]);

            if($fetch_result["forum_message_add_gmt_timestamp"] !=
                        $fetch_result["forum_message_edit_gmt_timestamp"])
            {
                $posts[$i]["post_edit_time"] =  $_LANG['edit_gmt'].
                " : ".
                format_time_stamp($fetch_result["forum_message_edit_gmt_timestamp"]);
            }

            $posts[$i]["post_content"] = ($fetch_result['forum_message_contenu']);

            $posts[$i]['usr_signature'] =   BBcode_parser($fetch_result['usr_signature']);

            $i++;
        }

        //here I order the post...

        $order_posts = order_posts_in_thread($_GET["forum_sujet_id"]);

        $posts2 = array();

        foreach($order_posts AS $forum_message_id)
        {
            foreach($posts AS $post)
            {
                if($post["forum_message_id"] == $forum_message_id)
                {
                    $posts2 []= $post;
                }
            }
        }

        $posts = $posts2;

        $smarty->assign('posts', $posts);
        $smarty->assign('_LANG', $_LANG);

        $smarty->assign('forums_link', "<a href=\"".__INICROND_INCLUDE_PATH__."modules/mod_forum/main_inc.php?cours_id=$cours_id\">".$_LANG['mod_forum']."</a>");

        $smarty->assign('forum_link', "<a href=\"".__INICROND_INCLUDE_PATH__."modules/mod_forum/forum_inc.php?forum_discussion_id=$forum_discussion_id\">".$forum_discussion_name."</a>");

        $cours =  get_cours_infos($cours_id);
        $smarty->assign('cours', $cours);
        $smarty->assign('discussion', $discussion);

    }

    $module_content .= $smarty->fetch($_OPTIONS['theme']."/thread.tpl", $cache_id);
    $smarty->caching = 0;
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>