<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : modétateurs pour discussions
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

if(isset($_OPTIONS["INCLUDED"])
)
{

	
//include "includes/fonctions/cbparser.php";//parser BBcode
	
$elements_titre = array(
$_LANG["23"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

	if(isset($_SESSION["sebhtml"]["usr_id"]) AND
	 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet))//admin seulement
	{
	$module_content .= "(";
	$module_content .= retournerHref("?module_id=27&mode_id=0", $_LANG["27"]["add"]);//add a section
	$module_content .= ")";
	}
	
	if(isset($_GET["forum_section_id"]) AND
	$_GET["forum_section_id"] != "" AND
	(int) $_GET["forum_section_id"] AND 
	!isset($_GET["mode_id"])
	)
	{
	$query = "SELECT
	 forum_section_id, forum_section_name
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]."
	WHERE
	forum_section_id=".$_GET["forum_section_id"]."
	ORDER BY order_id ASC
	;";
	}
	else
	{
	$query = "SELECT
	 forum_section_id, forum_section_name
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]."
	ORDER BY order_id ASC
	;";
	}
	
	
		$query_result = $mon_objet->query($query);
		
	
	while($fetch_result = $mon_objet->fetch_assoc($query_result))
	{
	$forum_section_id = $fetch_result["forum_section_id"];
	$forum_section_name = $fetch_result["forum_section_name"];
	
	$module_content .= "<p class=\"forum_section_name\">";
	$module_content .= retournerHref("?module_id=23&forum_section_id=".
	$fetch_result["forum_section_id"], $fetch_result["forum_section_name"]);
	
	$module_content .= "</p>";
	
	if(isset($_SESSION["sebhtml"]["usr_id"]) AND
	 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet))//admin seulement
		{
		$module_content .= " (";
		$module_content .= retournerHref("?module_id=23&mode_id=2&forum_section_id=".$fetch_result["forum_section_id"],
		 $_LANG["23"]["remove"]);//enlever
		 
		  
		 	$module_content .= " - ";
		$module_content .= retournerHref("?module_id=27&mode_id=1&forum_section_id=$forum_section_id",
		 $_LANG["27"]["edit"]);//edit
		$module_content .= " - ";
		$module_content .= retournerHref("?module_id=28&mode_id=0&forum_section_id=$forum_section_id",
		 $_LANG["28"]["add"]);//add a discussion
		
		 $module_content .= " - ";
		$module_content .= retournerHref("?module_id=23&mode_id=0&forum_section_id=".$fetch_result["forum_section_id"],
		 $_LANG["23"]["go_up"]);//monter
		 $module_content .=  " - ";
		$module_content .= retournerHref("?module_id=23&mode_id=1&forum_section_id=".$fetch_result["forum_section_id"],
		 $_LANG["23"]["go_down"]);//descendre
		 $module_content .= ")";
		 
		}
		

	$tableau = array();
	
	$tableau[] = array(
		 $_LANG["23"]["discussion"],
		
			

	 
	 $_LANG["23"]["nb_messages"],
			
	 $_LANG["23"]["nb_sujets"],
	 
	  $_LANG["23"]["last_post"]
	 );
			$queries["SELECT"] ++; // comptage	
		$query = "SELECT 
	forum_discussion_id, forum_discussion_name,
	forum_discussion_description
	FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
	WHERE
	forum_section_id=$forum_section_id
	ORDER BY 
	order_id ASC
	;";
	
		
			$query_result_2 = $mon_objet->query($query);
			
			
		while($fetch_result = $mon_objet->fetch_assoc($query_result_2))
		{
		$ligne = array();
	
		$forum_discussion_id = $fetch_result["forum_discussion_id"];
		
		
		$ligne []= "<b>".		
		
		retournerHref("?module_id=24&forum_discussion_id=".$fetch_result["forum_discussion_id"],
		 $fetch_result["forum_discussion_name"]).
		"</b><br />".
		 bb2html($fetch_result["forum_discussion_description"], "").//parseur bbcode à l'oeuvre...
		 "<br />";
		
		 //modérateurs et groupes authorisés.
		 
		 
		$sql = 
		"SELECT
		group_name, 	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_moderators"].".group_id
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_moderators"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."
		WHERE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_moderators"].".group_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].".group_id
		AND
		forum_discussion_id=$forum_discussion_id
		;";
		
		$query_result2 = $mon_objet->query($sql);
		
		$tableau2 = array();
		
		while($fetch_result = $mon_objet->fetch_assoc($query_result2))
		{
		$tableau2[] = array(retournerHref("?module_id=22&group_id=".
		$fetch_result["group_id"], $fetch_result["group_name"]));
		}
		
		$mon_objet->free_result($query_result2);
	
		$ligne [0] .= "<small>". $_LANG["33"]["titre"]."</small>";
			$ligne [0] .= retournerTableauXY($tableau2, "");
		
			//groupe authorisés.
		
		$tableau2 = array();
		$sql = 
		"SELECT
		right_thread_start, right_thread_reply
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
		WHERE
		
		forum_discussion_id=$forum_discussion_id
		;";
		
		$query_result2 = $mon_objet->query($sql);
		
		
		$fetch_result = $mon_objet->fetch_assoc($query_result2);
		
			
		$mon_objet->free_result($query_result2);
	
		
		if($fetch_result["right_thread_start"] == 0)
		{
		$group_name = $_LANG["28"]["all"];
		}
		else
		{
		$group_name = retournerHref("?module_id=22&group_id=".$fetch_result["right_thread_start"],
		group_name($fetch_result["right_thread_start"] , $mon_objet));
		}
		$tableau2[] = array($_LANG["28"]["right_thread_start"], 
		$group_name);
		
		if($fetch_result["right_thread_reply"] == -1)
		{
		$group_name = $_LANG["28"]["author"];
		}
		elseif($fetch_result["right_thread_reply"] == 0)
		{
		$group_name = $_LANG["28"]["all"];
		}
		else
		{
		$group_name = retournerHref("?module_id=22&group_id=".$fetch_result["right_thread_reply"],
		group_name($fetch_result["right_thread_reply"] , $mon_objet));
		}
		$tableau2[] = array($_LANG["28"]["right_thread_reply"], 
		$group_name);
		
		//$query_result = $mon_objet->query($sql);
		
	
		
		//$fetch_result = $mon_objet->fetch_assoc($query_result);
		
		$ligne [0] .= "<small>". $_LANG["23"]["droits"]."</small>";
			$ligne [0] .= retournerTableauXY($tableau2, "");
		
			
			if(isset($_SESSION["sebhtml"]["usr_id"]) AND
	 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet))//admin seulement
	{
	$ligne[0] .= 
		 " (".
		retournerHref("?module_id=28&mode_id=1&forum_discussion_id=".
		$forum_discussion_id, $_LANG["28"]["edit"]).
		//éditer une discussion
		 " - ".
		 
		 retournerHref("?module_id=33&forum_discussion_id=".$forum_discussion_id,
		 $_LANG["33"]["titre"]).//modérateurs
		 	 " - ".
		retournerHref("?module_id=23&mode_id=2&forum_discussion_id=".$forum_discussion_id,
		 $_LANG["23"]["rm_discussion"]).//
		  " - ".
		retournerHref("?module_id=23&mode_id=0&forum_discussion_id=".
		$forum_discussion_id,
		 $_LANG["23"]["go_up"]).//monter
		   " - ".
		retournerHref("?module_id=23&mode_id=1&forum_discussion_id=".
		$forum_discussion_id,
		 $_LANG["23"]["go_down"]).//
		 
		")" ;
	}
		
		
		
			//$queries["SELECT"] ++; // comptage		
		$query = "SELECT count(".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].".forum_message_id)
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
		WHERE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].".forum_discussion_id=$forum_discussion_id
		AND
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].".forum_sujet_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].".forum_sujet_id
		

	";
	
	
	if(!$query_result_3 = $mon_objet->query($query))
	{
	die($query." ".$mon_objet->error());
	}
	
	$fetch_result = $mon_objet->fetch_assoc($query_result_3);
	
	$mon_objet->free_result($query_result_3);
	
	
	$ligne[] = $fetch_result["count(".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].".forum_message_id)"];
			$queries["SELECT"] ++; // comptage	
	
		$query = "SELECT count(forum_sujet_id)
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
		WHERE
		forum_discussion_id=$forum_discussion_id
		;";
		$query_result_3 = $mon_objet->query($query);
		$fetch_result = $mon_objet->fetch_assoc($query_result_3);
	
		$mon_objet->free_result($query_result_3);
		
		$ligne[] = $fetch_result["count(forum_sujet_id)"];
			$queries["SELECT"] ++; // comptage		
		$query = "SELECT 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].".forum_sujet_id,
		forum_message_titre, 
		forum_message_id,
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].",
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].",
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
		WHERE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].".forum_discussion_id=$forum_discussion_id
		AND
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].".forum_sujet_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].".forum_sujet_id
		AND
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].".usr_id
		ORDER BY forum_message_add_gmt_timestamp DESC
		LIMIT 1
		;";
		
			if(!$query_result_3 = $mon_objet->query($query))
			{
			die($query." ".$mon_objet->error());
			}
			
		$fetch_result = $mon_objet->fetch_assoc($query_result_3);
	
		$mon_objet->free_result($query_result_3);
		
		//------------
		//dernier post
		//-------------
		$ligne[] = retournerHref("?module_id=25&forum_sujet_id=".
		$fetch_result["forum_sujet_id"]."#".$fetch_result["forum_message_id"], 
		$fetch_result["forum_message_titre"]). " (".
		retournerHref("?module_id=4&usr_id=".
		$fetch_result["usr_id"], 
		$fetch_result["usr_name"])
		.")";
		
		
		$tableau[] = $ligne;
		
		}
	
	$mon_objet->free_result($query_result_2);
	
	$module_content .= retournerTableauXY($tableau);
	}
$mon_objet->free_result($query_result);

}
?>

