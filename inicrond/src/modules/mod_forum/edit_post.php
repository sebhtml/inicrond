<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : 
start thread
edit mesg
repley
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond
//
//---------------------------------------------------------------------



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




if(isset($_GET["forum_message_id"]) AND
$_GET["forum_message_id"] != "" AND
(int) $_GET["forum_message_id"] )
{
	//get the usr_id if the person wants to edit.
        $query = "SELECT usr_id
	FROM 
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
	WHERE
	forum_message_id=".$_GET["forum_message_id"]."
	";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        
        if(
        
        $_SESSION['usr_id'] == $fetch_result['usr_id']
        
	)
        //éditer
        {
                
		$forum_message_id = $_GET["forum_message_id"];
                
		$query = "SELECT usr_id
		FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
		WHERE
		forum_message_id=$forum_message_id
		";
                
		$rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
		
                
                //get the forum_sujet_id+forum_sujet_name
		$query = "SELECT 
		forum_sujet_id
                FROM
                
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
                
                WHERE
                forum_message_id=".$_GET["forum_message_id"]."
                
                ";
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
                $sujet_id = $fetch_result["forum_sujet_id"];
                
		$query = "SELECT 
                forum_message_titre
                FROM
                
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
                
                WHERE
                forum_sujet_id=$sujet_id
                ORDER BY forum_message_id ASC
                
                ";
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
                
                $sujet_name = $fetch_result["forum_message_titre"];
                
                $query = "SELECT 
                forum_discussion_name, 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id,
                forum_message_titre,
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id,
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_message_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages'].".forum_sujet_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_discussion_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_discussion_id
                AND
                forum_message_id=".$_GET["forum_message_id"]."
                ORDER BY forum_message_id ASC";
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
                
                
                
                
                
                //titre
                $module_title = $fetch_result["forum_message_titre"];
		
                
                if(isset($_POST["sent"]) AND $_POST["forum_message_titre"] != "" AND $_POST['forum_message_contenu'] != "")
                {
                        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";
			$forum_message_titre = filter($_POST["forum_message_titre"]);
			$forum_message_contenu = filter_html_preserve($_POST['forum_message_contenu']);
			//$adresse_ip = $_SERVER['REMOTE_ADDR'];
			$forum_message_edit_gmt_timestamp = inicrond_mktime();
                        
			$query = "UPDATE ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
			SET
                        
			forum_message_titre='$forum_message_titre',
			forum_message_contenu='$forum_message_contenu',
                        
			forum_message_edit_gmt_timestamp=$forum_message_edit_gmt_timestamp
                        
			WHERE
                        
			forum_message_id=$forum_message_id
			;";
                        
                        $inicrond_db->Execute($query);
                        
                        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
                        
                        js_redir("thread_inc.php?forum_sujet_id=".
			message2sujet($_GET["forum_message_id"])
			);
                        
                }
                else//le formulaire pour éditer
                {
                        
                        $query = "SELECT forum_message_titre, forum_message_contenu
                        FROM 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_messages']."
                        WHERE
                        forum_message_id=$forum_message_id
                        ;";
                        
                        $rs = $inicrond_db->Execute($query);
                        $fetch_result = $rs->FetchRow();
                        
                        
			$forum_message_titre = $fetch_result["forum_message_titre"];
			$forum_message_contenu = $fetch_result['forum_message_contenu'];
                        
			include "includes/forms/postit_inc.form.php";
                        
                }
                
                
        }
	
}


include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>

