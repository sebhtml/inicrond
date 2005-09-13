<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : voir discussion
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
if(isset($_GET["forum_discussion_id"]) AND
$_GET["forum_discussion_id"] != "" AND
(int) $_GET["forum_discussion_id"] AND
can_usr_view_forum($_SESSION['usr_id'], $_GET["forum_discussion_id"])

)
{
        
        
	$query = "SELECT 
	forum_discussion_name,
	cours_id
	FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
	WHERE
	forum_discussion_id=".$_GET["forum_discussion_id"]."
	AND
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id
	";
	
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
	
	
        $cours_id = $fetch_result['cours_id'];	
        
        
        
        
        // titre
        $module_title = $fetch_result["forum_discussion_name"];
	
        
        $right_thread_start = $fetch_result["right_thread_start"]; // pour tout suite en tantot !
	
	if(
	
	
	can_usr_start_thread($_SESSION['usr_id'], $_GET["forum_discussion_id"])
	
	)
	{
                $can_start = 1 ;
                $smarty->assign("start_a_thread_url",  "start_thread.php?forum_discussion_id=".$_GET["forum_discussion_id"]."", $_LANG['start']);
	}
	else
	{
                $can_start = 0 ;
	}
	
	if($_OPTIONS['smarty_cache_config']['mod_forum']["forum_thread_listing.tpl"])// != 0
        {
                $smarty->caching = 1;
                $smarty->cache_lifetime = $_OPTIONS['smarty_cache_config']['mod_forum']["forum_thread_listing.tpl"];
        }
        $cache_id = md5(
        $_SESSION['language'].
        $_GET["forum_discussion_id"].
        $can_start
        ) ;
        
        if(!$smarty->is_cached($_OPTIONS['theme']."/forum_thread_listing.tpl", $cache_id))
        {
                
                $threads = array();
                
                
                
                $query = "SELECT 
                forum_sujet_id, locked
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
                WHERE
                forum_discussion_id=".$_GET["forum_discussion_id"]."
                ORDER BY forum_sujet_id DESC
                ";
                
                $rs = $inicrond_db->Execute($query);
                $i = 0;
                
                $threads = array();
                $threads[$i] = array($_LANG['sujet'], $_LANG['status'], $_LANG['starter'], $_LANG['startup_date'], $_LANG['nb_answer'], $_LANG['nb_views']);
                
                $i++;
                while($fetch_result = $rs->FetchRow())
                {
                        
                        $forum_sujet_id = $fetch_result["forum_sujet_id"];
                        $etat = $fetch_result["locked"];
                        
                        
                        $query = "SELECT forum_message_titre, ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_name, ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
                        forum_message_add_gmt_timestamp AS THEdate,
                        usr_nom,
                        usr_prenom
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                        WHERE
                        forum_sujet_id=$forum_sujet_id
                        AND
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".usr_id
                        ";
                        
                        $rs2 = $inicrond_db->Execute($query);
                        $fetch_result = $rs2->FetchRow();
                        
                        $ligne = array();
                        
                        
                        $threads[$i]['sujet'] =
                        
                        
                        retournerHref("thread_inc.php?forum_sujet_id=$forum_sujet_id", $fetch_result["forum_message_titre"]."");
                        
                        
                        $threads[$i]['status'] = ($etat == 1) ? $_LANG['closed'] :  $_LANG['open']  ;
                        
                        
                        $threads[$i]['starter'] =  1 ?
                        
                        retournerHref("".__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result['usr_id'], $fetch_result['usr_name']." (".$fetch_result['usr_prenom']." ".$fetch_result['usr_nom'].")") : $fetch_result['usr_name'];
                        
                        $threads[$i]['startup_date'] = 	(format_time_stamp($fetch_result["THEdate"]));	
                        
                        //--------
                        //nombre de réponses
                        //-----------
                        
                        //		$queries["SELECT"] ++; // comptage
                        $query = "SELECT count(forum_message_id)
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
                        WHERE
                        forum_sujet_id=$forum_sujet_id
                        ";
                        
                        $rs2 = $inicrond_db->Execute($query);
                        $fetch_result = $rs2->FetchRow();
                        
                        
                        $threads[$i]['nb_answer'] =
                        
                        ($fetch_result["count(forum_message_id)"] -1);
                        
                        //-------------
                        //nombre de views
                        //-------------
                        //		$queries["SELECT"] ++; // comptage
                        $query = "SELECT 
                        count(usr_id) AS nb_views
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['views_of_threads']."
                        WHERE
                        forum_sujet_id=$forum_sujet_id
                        ";
                        
                        $rs2 = $inicrond_db->Execute($query);
                        $fetch_result = $rs2->FetchRow();
                        
                        $threads[$i]['nb_views'] =
                        
                        ($fetch_result['nb_views'] );
                        
                        
                        $i++;
                }
                
                
                $smarty->assign('threads', $threads);
                $smarty->assign('_LANG', $_LANG);
                
                $smarty->assign('forums_link', "<h3><a href=\"".__INICROND_INCLUDE_PATH__."modules/mod_forum/main_inc.php?&cours_id=$cours_id\">".$_LANG['mod_forum']."</a></h3>"); 
                
                
                $cours =  get_cours_infos($cours_id);
                $smarty->assign('cours', $cours); 
                
        }
	
	$module_content .= $smarty->fetch($_OPTIONS['theme']."/forum_thread_listing.tpl", $cache_id);
        $smarty->caching = 0;
	
	
}
include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>