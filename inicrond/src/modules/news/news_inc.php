<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : accueil
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
include "modules/news/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";

if(isset($_OPTIONS["INCLUDED"]))
{
$elements_titre = array(
$_LANG["32"]["titre"]
);

$module_title = "";
$module_content = "";

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);



//---------------
//news
//------------------

if(!isset($_OPTIONS["news_forum_discussion_id"]))
{
echo "\$_OPTIONS[\"news_forum_discussion_id\"] not set";
}
	$query = " 
		
	
	SELECT
	 forum_discussion_name
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
	WHERE
	forum_discussion_id=".$_OPTIONS["news_forum_discussion_id"]."
	
	;";
	
	$query_result = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result);
	
	$mon_objet->free_result($query_result);
	
	
$module_content .= "<b>";
$module_content .= retournerHref("?module_id=24&forum_discussion_id=".$_OPTIONS["news_forum_discussion_id"]."", $fetch_result["forum_discussion_name"]);

$module_content .= "</b>";

$module_content .= "<br />";

	$queries["SELECT"] ++; // comptage

	$query = "SELECT forum_sujet_id
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
	WHERE
	forum_discussion_id=".$_OPTIONS["news_forum_discussion_id"]."
	ORDER BY forum_sujet_id DESC
	LIMIT 10
	;";
	
	$query_result = $mon_objet->query($query);
	
	while($fetch_result = $mon_objet->fetch_assoc($query_result))
	{
	
	$forum_sujet_id = $fetch_result["forum_sujet_id"];

			$queries["SELECT"] ++; // comptage	
	$query = "SELECT forum_message_titre,
	forum_message_contenu,
	forum_message_add_gmt_timestamp,
	 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	forum_sujet_id=".$fetch_result["forum_sujet_id"]."
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].".usr_id
	;";
	
	$query_result_2 = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	
	$mon_objet->free_result($query_result_2);
	

	//titre
	$module_content .= retournerHref("?module_id=25&forum_sujet_id=$forum_sujet_id", $fetch_result["forum_message_titre"]);

$module_content .= " ";
$module_content .= $_LANG["32"]["by"];

$image = "";
	
	if(is_file($_OPTIONS["usrs_pics"]."/".$fetch_result["usr_id"]))
	{
	$image =
"<br /><img src=\"download.php?usrs_pics=".$fetch_result["usr_id"]."\" />";

	}
	
	$module_content .= " ";
	$module_content .= retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"], $fetch_result["usr_name"].$image);
	
$module_content .= "<br />";

$module_content .= "<small>";

$module_content .= format_time_stamp($fetch_result["forum_message_add_gmt_timestamp"],
 $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);//affiche la date d'aujourd'hui




$module_content .= "</small>";	

$module_content .= "<br />";

$module_content .= "<p align=\"justify\">";

$module_content .= bb2html($fetch_result["forum_message_contenu"], "");

$module_content .= "</p>";

$module_content .= "<br />";

$module_content .= "<small>";
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


	
	$module_content .= ($fetch_result["count(forum_message_id)"] -1)." ".$_LANG["32"]["answers"];
	
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


$module_content .= ", ";
	$module_content .= ($fetch_result["nb_views"])." ".$_LANG["32"]["views"];
	//($fetch_result[""] );
	
	
$module_content .= "</small>";

$module_content .= "<hr>";
	}

}
?>
