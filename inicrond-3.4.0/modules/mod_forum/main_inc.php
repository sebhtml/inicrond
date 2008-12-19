<?php
/*
    $Id: main_inc.php 94 2006-01-04 01:12:12Z sebhtml $

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

// PAS DE ELSE, CELA AFFICHE LE FORUM ARGH!!

if(isset($_GET['cours_id']) && $_GET['cours_id'] != ""  && (int) $_GET['cours_id']
&& is_student_of_cours($_SESSION['usr_id'],$_GET['cours_id']))
{
    $_SESSION['cours_id'] = $_GET['cours_id'];

    $is_teacher_of_cours = (is_teacher_of_cours($_SESSION['usr_id'],  $_GET['cours_id']) || $_SESSION['SUID']);

    // titre
    $module_title = $_LANG['mod_forum'];

    if($_OPTIONS['smarty_cache_config']['mod_forum']["main.tpl"] != 0)
    {
        $smarty->caching = 1;
        $smarty->cache_lifetime = $_OPTIONS['smarty_cache_config']['mod_forum']["main.tpl"];
    }

    $cache_id = md5($_SESSION['language'].$_SESSION['usr_id']) ;

    if(!$smarty->is_cached($_OPTIONS['theme']."/main.tpl", $cache_id))
    {
        $query = "
        SELECT
        forum_section_id,
        forum_section_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
        WHERE
        cours_id=".$_GET['cours_id']."
        ORDER BY order_id ASC
        ";

        $rs = $inicrond_db->Execute($query);

        $sections = array();

        while($fetch_result = $rs->FetchRow())
        {
            if(!can_usr_view_section($_SESSION['usr_id'], $fetch_result["forum_section_id"]))
            {
                continue;//skip this loop
            }

            $section = array();

            $forum_section_id = $fetch_result["forum_section_id"];
            $forum_section_name = $fetch_result["forum_section_name"];

            $section['title'] = $fetch_result["forum_section_name"];

            if($is_teacher_of_cours)
            {
                $section["rm_link"] =  retournerHref("section_remove.php?&forum_section_id=".$fetch_result["forum_section_id"],
                $_LANG['remove']);//enlever

                $section["edit_link"] = retournerHref("add_edit_section_inc.php?mode_id=1&forum_section_id=$forum_section_id",
                $_LANG['edit']);//edit

                $section["add_forum_link"] = retournerHref("add_edit_forum_inc.php?&mode_id=0&forum_section_id=$forum_section_id",
                $_LANG['add']);//add a discussion

                $section["up_link"] = retournerHref("section_up.php?forum_section_id=".$fetch_result["forum_section_id"],
                $_LANG['get_it_up']);//monter

                $section["down_link"] = retournerHref("section_down.php?forum_section_id=".$fetch_result["forum_section_id"],
                $_LANG['get_it_down']);//descendre

                $section['section_viewers'] = retournerHref("section_viewers.php?&forum_section_id=".$fetch_result["forum_section_id"],
                $_LANG['section_viewers']);//descendre
            }

            $query = "
            SELECT
            forum_discussion_id,
            forum_discussion_name,
            forum_discussion_description
            FROM ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
            WHERE
            forum_section_id=$forum_section_id
            ORDER BY
            order_id ASC
            ";

            $rs2 = $inicrond_db->Execute($query);

            $section["forums"] = array();

            while ($fetch_result = $rs2->FetchRow())
            {
                $forum = array();

                //can't view this forum...

                if(!can_usr_view_forum($_SESSION['usr_id'], $fetch_result["forum_discussion_id"]))
                {
                    continue;//skip this loop
                }

                $forum_discussion_id = $fetch_result["forum_discussion_id"];

                $forum["link"] = retournerHref("forum_inc.php?&forum_discussion_id=".$fetch_result["forum_discussion_id"],
                $fetch_result["forum_discussion_name"]);

                $forum['description'] = BBcode_parser($fetch_result["forum_discussion_description"]);

                // check if the user have a subscription

                $query = '
                select
                usr_id
                from
                '.$_OPTIONS['table_prefix'].'forum_subscription
                where
                usr_id = '.$_SESSION['usr_id'].'
                and
                forum_discussion_id = '.$forum_discussion_id.'
                ' ;

                $rs_for_subscription = $inicrond_db->Execute ($query) ;
                $row = $rs_for_subscription->FetchRow () ;

                if (isset ($row['usr_id']))
                {
                    $script = 'unsubscribe_from_a_forum' ;
                }
                else
                {
                    $script = 'subscribe_to_a_forum' ;
                }

                $forum['sub_or_unsub_link'] = '<a href="'.$script.'.php?forum_discussion_id='.$forum_discussion_id.'">'.$_LANG[$script].'</a>' ;

                // end of the unsubscribe or subscribe link.

                if(can_usr_admin_section($_SESSION['usr_id'],
                forum_2_section($fetch_result["forum_discussion_id"])))//éditer une discussion
                {
                    $forum['edit'] = retournerHref("add_edit_forum_inc.php?&mode_id=1&forum_discussion_id=".
                    $forum_discussion_id, $_LANG['edit']);
                }

                if(                $is_teacher_of_cours)
                {
                    $forum['moderators'] = retournerHref("forum_moderators.php?&forum_discussion_id=".$forum_discussion_id,
                    $_LANG['moderators']);//

                    $forum["starters"] =retournerHref("forum_starters.php?&forum_discussion_id=".$forum_discussion_id,
                    $_LANG['forums_groups_start']);//

                    $forum["reply_ppl"] =retournerHref("forum_reply_grp.php?&forum_discussion_id=".$forum_discussion_id,
                    $_LANG['forums_groups_reply']);//modérateurs

                    $forum["viewers"] = retournerHref("forum_viewers.php?&forum_discussion_id=".$forum_discussion_id,
                    $_LANG['forum_viewers']);//modérateurs

                    $forum["rm"] = retournerHref("forum_remove.php?forum_discussion_id=".$forum_discussion_id,
                    $_LANG['remove']);//

                    $forum["up"] =retournerHref("forum_up.php?forum_discussion_id=".
                    $forum_discussion_id,
                    $_LANG['get_it_up']);//monter

                    $forum["down"] = retournerHref("forum_down.php?forum_discussion_id=".
                    $forum_discussion_id,
                    $_LANG['get_it_down']);//
                }

                $query = "
                SELECT count(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_message_id)
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id=$forum_discussion_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
                ";

                $rs3 = $inicrond_db->Execute($query);
                $fetch_result = $rs3->FetchRow();

                $forum["nb_posts"] = $fetch_result["count(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_message_id)"];

                $query = "
                SELECT
                count(forum_sujet_id)
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
                WHERE
                forum_discussion_id=$forum_discussion_id
                ";

                $rs3 = $inicrond_db->Execute($query);
                $fetch_result = $rs3->FetchRow();

                $forum["nb_threads"] = $fetch_result["count(forum_sujet_id)"];

                $query = "
                SELECT
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id,
                forum_message_titre,
                forum_message_id,
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id, ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_name,
                usr_nom,
                usr_prenom
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id=$forum_discussion_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".usr_id
                ORDER BY forum_message_add_gmt_timestamp DESC
                LIMIT 1
                ";

                $rs3 = $inicrond_db->Execute($query);
                $fetch_result = $rs3->FetchRow();

                //------------
                //dernier post
                //-------------

                $forum['last_post'] = retournerHref("thread_inc.php?forum_sujet_id=".
                $fetch_result["forum_sujet_id"]."#".$fetch_result["forum_message_id"],
                $fetch_result["forum_message_titre"]);

                $forum["last_poster"] =

                retournerHref(__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".
                $fetch_result['usr_id'],
                $fetch_result['usr_name']." (".$fetch_result['usr_prenom']." ".$fetch_result['usr_nom'].")")
                ;

                $section["forums"] []= $forum;
            }

            $sections []= $section;
        }

        $smarty->template_dir = 'templates/';

        $smarty->assign('sections', $sections);
        $smarty->assign('nb_post_title', $_LANG['nb_messages']);
        $smarty->assign('nb_thread_title', $_LANG['nb_sujets']);
        $smarty->assign('last_post_title',  $_LANG['last_post']);
        $smarty->assign('forum_title', $_LANG['discussion']);

        $smarty->assign('search_forums', "<a href=\"search_forums.php?cours_id=".$_GET['cours_id']."\">".$_LANG['search_forums']."</a>");

        $cours =  get_cours_infos($_GET['cours_id']);
        $smarty->assign('cours', $cours);

        $smarty->assign('cours_id', $_GET['cours_id']);
        $smarty->assign('_LANG', $_LANG);

        if($is_teacher_of_cours)//admin seulement
        {
            $smarty->assign('add_section_link', retournerHref("add_edit_section_inc.php?&mode_id=0&cours_id=".$_GET['cours_id']."", $_LANG['add']));
        }
    }

    $module_content .= $smarty->fetch($_OPTIONS['theme']."/main.tpl", $cache_id);
    $smarty->caching = 0;
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>