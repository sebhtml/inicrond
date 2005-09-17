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
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
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
include "modules/forum/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}
elseif(isset($_GET["forum_discussion_id"]) AND
$_GET["forum_discussion_id"] != "" AND
(int) $_GET["forum_discussion_id"]
)
{
	
	$forum_discussion_id = $_GET["forum_discussion_id"];
	//$queries["SELECT"] ++; // comptage
	$query = "SELECT forum_discussion_name, right_thread_start
	FROM
	 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
	WHERE
	forum_discussion_id=$forum_discussion_id;";
	
	$query_result = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result);
	
	$mon_objet->free_result($query_result);
	
	
	


$elements_titre = array(
retournerHref("?module_id=23", $_LANG["23"]["titre"]),
$fetch_result["forum_discussion_name"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);
	

$right_thread_start = $fetch_result["right_thread_start"]; // pour tout suite en tantot !
	
	if(isset($_SESSION["sebhtml"]["usr_id"]) AND 
	( $right_thread_start == 0 ||
	 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $right_thread_start, $mon_objet)) )
	{
	$module_content .= retournerHref("?module_id=26&forum_discussion_id=$forum_discussion_id", $_LANG["26"]["start"]);
	}
	

	
	$tableau = array();
	
	$tableau [] = array(

	$_LANG["24"]["sujet"],
		$_LANG["24"]["status"],
	
	
	$_LANG["24"]["starter"],
		
	
	
	 $_LANG["24"]["nb_answer"],
	 
	 $_LANG["24"]["nb_views"]
	);	

			

	$query = "SELECT 
	forum_sujet_id, locked
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
	WHERE
	forum_discussion_id=$forum_discussion_id
	ORDER BY forum_sujet_id DESC
	;";
	
	$query_result = $mon_objet->query($query);
	
	while($fetch_result = $mon_objet->fetch_assoc($query_result))
	{
	
	
	$forum_sujet_id = $fetch_result["forum_sujet_id"];
	$etat = $fetch_result["locked"];
	

	$query = "SELECT forum_message_titre, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	forum_sujet_id=$forum_sujet_id
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].".usr_id
	;";
	
	$query_result_2 = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	
	$mon_objet->free_result($query_result_2);
	
$ligne = array();


$ligne[] =
	

	retournerHref("?module_id=25&forum_sujet_id=$forum_sujet_id", $fetch_result["forum_message_titre"]."");

	
$ligne[] = ($etat == 1) ? $_LANG["24"]["closed"] :  $_LANG["24"]["open"]  ;


$ligne[] =
	
	retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"], $fetch_result["usr_name"]);
	
	
	
//--------
//nombre de réponses
//-----------

			$queries["SELECT"] ++; // comptage
	$query = "SELECT count(forum_message_id)
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
	WHERE
	forum_sujet_id=$forum_sujet_id
	;";
	
	$query_result_2 = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	
	$mon_objet->free_result($query_result_2);

$ligne[] =
	
	($fetch_result["count(forum_message_id)"] -1);
	
	//-------------
	//nombre de views
	//-------------
	//		$queries["SELECT"] ++; // comptage
	$query = "SELECT 
	count(session_id) AS nb_views
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_threads"]."
	WHERE
	forum_sujet_id=$forum_sujet_id
	;";
	
	$query_result_2 = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	
	$mon_objet->free_result($query_result_2);

$ligne[] =
	
	($fetch_result["nb_views"] );
	
	
	$tableau[] = $ligne;
	}
	$mon_objet->free_result($query_result);
	
	$module_content .= retournerTableauXY($tableau);
	
	if(isset($_SESSION["sebhtml"]["usr_id"]) AND 
	( $right_thread_start == 0 ||
	 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $right_thread_start, $mon_objet)) )
	{
	$module_content .= retournerHref("?module_id=26&forum_discussion_id=$forum_discussion_id", $_LANG["26"]["start"]);
	}
	
}
	

?>

