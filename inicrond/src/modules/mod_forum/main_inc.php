<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : forum main()
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond
//
//---------------------------------------------------------------------
*/

/*


http://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.


*/

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';


include "includes/functions/access.php";
include "includes/functions/conversion.inc.php";

//PAS DE ELSE, CELA AFFICHE LE FORUM ARGH!!
if(
isset($_GET['cours_id'])  AND
$_GET['cours_id'] != ""  AND
(int) $_GET['cours_id'] AND
is_student_of_cours($_SESSION['usr_id'],$_GET['cours_id'] )
)

{
        $_SESSION['cours_id'] = $_GET['cours_id'];
        
        $is_teacher_of_cours = (is_teacher_of_cours($_SESSION['usr_id'],  $_GET['cours_id'])  OR $_SESSION['SUID']);
	
        //include "includes/fonctions/cbparser.php";//parser BBcode
	
        
        
        
        // titre
        $module_title = $_LANG['mod_forum'];
        
        
	if($_OPTIONS['smarty_cache_config']['mod_forum']["main.tpl"])// != 0
        {
                $smarty->caching = 1;
                $smarty->cache_lifetime = $_OPTIONS['smarty_cache_config']['mod_forum']["main.tpl"];
        }
        $cache_id = md5(
        $_SESSION['language'].
        $_SESSION['usr_id']
        ) ;
        if(!$smarty->is_cached($_OPTIONS['theme']."/main.tpl", $cache_id))
        {	
                
                
                
                $query = "SELECT
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
                        
                        if(!(
                        
                        can_usr_view_section($_SESSION['usr_id'], $fetch_result["forum_section_id"])
                        ))
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
                                
                        }
                        if($is_teacher_of_cours)
                        
                        
                        
                        { 
                                
                                $section["edit_link"] = retournerHref("add_edit_section_inc.php?mode_id=1&forum_section_id=$forum_section_id",
                                $_LANG['edit']);//edit
                        }
                        
                        if($is_teacher_of_cours)
                        
                        
                        {
                                $section["add_forum_link"] = retournerHref("add_edit_forum_inc.php?&mode_id=0&forum_section_id=$forum_section_id",
                                $_LANG['add']);//add a discussion
                        }
                        
                        if($is_teacher_of_cours)
                        {
                                $section["up_link"] = retournerHref("section_up.php?forum_section_id=".$fetch_result["forum_section_id"],
                                $_LANG['get_it_up']);//monter
                        }
                        
                        if($is_teacher_of_cours)
                        {
                                $section["down_link"] = retournerHref("section_down.php?forum_section_id=".$fetch_result["forum_section_id"],
                                $_LANG['get_it_down']);//descendre
                                
                                
                        }
                        if($is_teacher_of_cours)  
                        
                        
                        
                        {
                                $section['section_viewers'] = retournerHref("section_viewers.php?&forum_section_id=".$fetch_result["forum_section_id"],
                                $_LANG['section_viewers']);//descendre
                                
                                
                        }
                        
                        
                        
                        $query = "SELECT 
                        forum_discussion_id, forum_discussion_name,
                        forum_discussion_description
                        FROM ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
                        WHERE
                        forum_section_id=$forum_section_id
                        ORDER BY 
                        order_id ASC
                        ";
                        
                        
                        $rs2 = $inicrond_db->Execute($query);
			
                        
                        
                        $section["forums"] = array();
                        
                        while($fetch_result = $rs2->FetchRow())
                        {
                                
                                $forum = array();
                                //can't view this forum...
                                if(!(
                                
                                can_usr_view_forum($_SESSION['usr_id'], $fetch_result["forum_discussion_id"])
                                
                                ))
                                {
                                        
                                        continue;//skip this loop
                                }
                                
                                
                                
                                
                                $forum_discussion_id = $fetch_result["forum_discussion_id"];
                                
                                
				
                                
                                $forum["link"] = retournerHref("forum_inc.php?&forum_discussion_id=".$fetch_result["forum_discussion_id"],
                                $fetch_result["forum_discussion_name"]);
                                
                                $forum['description'] = BBcode_parser($fetch_result["forum_discussion_description"]);
                                
                                
                                if(
                                
                                
                                can_usr_admin_section($_SESSION['usr_id'], forum_2_section($fetch_result["forum_discussion_id"]))  
                                ) 
                                
                                
                                
                                {
                                        $forum['edit'] = retournerHref("add_edit_forum_inc.php?&mode_id=1&forum_discussion_id=".
                                        $forum_discussion_id, $_LANG['edit']);
                                        //éditer une discussion
                                        
                                        
                                        
                                        
                                }
                                if(
                                $is_teacher_of_cours)
                                {
                                        $forum['moderators'] = retournerHref("forum_moderators.php?&forum_discussion_id=".$forum_discussion_id,
                                        $_LANG['moderators']);//
                                        
                                }
                                if(
                                $is_teacher_of_cours)
                                
                                
                                {
                                        $forum["starters"] =retournerHref("forum_starters.php?&forum_discussion_id=".$forum_discussion_id,
                                        $_LANG['forums_groups_start']);//
                                        
                                }
                                if(
                                $is_teacher_of_cours)
                                
                                
                                
                                {
                                        $forum["reply_ppl"] =retournerHref("forum_reply_grp.php?&forum_discussion_id=".$forum_discussion_id,
                                        $_LANG['forums_groups_reply']);//modérateurs
                                        
                                }
                                if(
                                $is_teacher_of_cours)
                                
                                
                                
                                {
                                        $forum["viewers"] = retournerHref("forum_viewers.php?&forum_discussion_id=".$forum_discussion_id,
                                        $_LANG['forum_viewers']);//modérateurs
                                        
                                }
                                if($is_teacher_of_cours
                                )
                                
                                
                                {	
                                        $forum["rm"] = retournerHref("forum_remove.php?forum_discussion_id=".$forum_discussion_id,
                                        $_LANG['remove']);//
                                }
                                if(
                                $is_teacher_of_cours)
                                
                                
                                {
                                        $forum["up"] =retournerHref("forum_up.php?forum_discussion_id=".
                                        $forum_discussion_id,
                                        $_LANG['get_it_up']);//monter
                                        
                                }
                                if(
                                $is_teacher_of_cours)
                                
                                
                                {
                                        $forum["down"] = retournerHref("forum_down.php?forum_discussion_id=".
                                        $forum_discussion_id,
                                        $_LANG['get_it_down']);//
                                        
                                        
                                }
                                
                                
                                
                                //$queries["SELECT"] ++; // comptage		
                                $query = "SELECT count(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_message_id)
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
                                
                                
                                $query = "SELECT count(forum_sujet_id)
                                FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
                                WHERE
                                forum_discussion_id=$forum_discussion_id
                                ";
                                $rs3 = $inicrond_db->Execute($query);
                                $fetch_result = $rs3->FetchRow();
                                
                                
                                $forum["nb_threads"] = $fetch_result["count(forum_sujet_id)"];
                                
                                $query = "SELECT 
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
                                
                                retournerHref("../../modules/members/one.php?usr_id=".
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