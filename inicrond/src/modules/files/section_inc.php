<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : section de téléchargement
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
//-------------------

//--------------------
include "modules/files/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}
else
{
	if((isset($_GET["uploaded_files_section_id"]) AND
	$_GET["uploaded_files_section_id"] != "" AND
	(int) $_GET["uploaded_files_section_id"]
	))
	
	{
		//-----
		//titre :
		//------
		//$queries["SELECT"] ++; // comptage

		$query = "SELECT uploaded_files_section_name 
		FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files_sections"]."
		WHERE 
		uploaded_files_section_id=".$_GET["uploaded_files_section_id"]."
		;";

		$query_result = $mon_objet->query($query);


		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);
		
	
//-----------
//titre de la page::
//--------------
$elements_titre = array(
retournerHref("?module_id=1", $_LANG["1"]["titre"]),
$fetch_result["uploaded_files_section_name"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


		//--------------
		//la requêtes :
		//-------------
		

	
		if(isset($_SESSION["sebhtml"]["usr_id"]) AND
		right_add_a_file($_SESSION["sebhtml"]["usr_id"], $_GET["uploaded_files_section_id"], $mon_objet)
		)//ajouter un ifchier
		{
		$module_content .= "<br />";
		$module_content .= retournerHref("?module_id=15&uploaded_files_section_id=".$_GET["uploaded_files_section_id"],
		$_LANG["15"]["titre"]);

		}
		
	$query = "SELECT 
	uploaded_file_title, uploaded_file_id, 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name
	FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE 
	uploaded_files_section_id=".$_GET["uploaded_files_section_id"]."
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].".usr_id
	ORDER BY 
	uploaded_file_edit_gmt_timestamp DESC
	;";
	
	
	}
	elseif(isset($_GET["usr_id"]) AND
	$_GET["usr_id"] != "" AND
	(int) $_GET["usr_id"]
	)
	{
	
	//-----
		//titre :
		//------
	//	$queries["SELECT"] ++; // comptage

		$query = "SELECT 
		usr_name 
		FROM
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
		WHERE
		 usr_id=".$_GET["usr_id"]."
		;";

		$query_result = $mon_objet->query($query);


		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);
		
		
	
//-----------
//titre de la page::
//--------------
$elements_titre = array(
retournerHref("?module_id=8",$_LANG["8"]["titre"]),
retournerHref("?module_id=4&usr_id=".$_GET["usr_id"],
		$fetch_result["usr_name"]),
$_LANG["1"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);
		
		//--------------
		//la requêtes :
		//-------------
		
		$queries["SELECT"] ++; // comptage

	$query = "SELECT 
	uploaded_file_title, uploaded_file_id, 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name
	FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].".usr_id=".$_GET["usr_id"]."
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].".usr_id
	ORDER BY 
	uploaded_file_edit_gmt_timestamp DESC
	;";
	
	
	}
	//$uploaded_files_section_id = $_GET["uploaded_files_section_id"];
	
	

	

	

	$query_result = $mon_objet->query($query);
	

	$result = array();

	$result [] = array($_LANG["15"]["source_name"], $_LANG["4"]["usr_name"],
	 $_LANG["common"]["nb_views"], $_LANG["6"]["nb_downloads"]);
	
		while($r = $mon_objet->fetch_assoc($query_result)) 
		{
		$query = "SELECT 
	count(session_id) AS nb_views
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_files"]."
	WHERE
	uploaded_file_id=".$r["uploaded_file_id"]."
	;";
	
	$query_result_2 = $mon_objet->query($query);
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	$mon_objet->free_result($query_result_2);

		$r["nb_views"] = $fetch_result["nb_views"];
		
		$query = "SELECT 
	count(session_id) AS nb_downloads
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["downloads_of_files"]."
	WHERE
	uploaded_file_id=".$r["uploaded_file_id"]."
	;";
	
	$query_result_2 = $mon_objet->query($query);
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	$mon_objet->free_result($query_result_2);

		$r["nb_downloads"] = $fetch_result["nb_downloads"];
		
		
		$result[] = array(retournerHref("?module_id=6&uploaded_file_id=".$r["uploaded_file_id"],
		 $r["uploaded_file_title"]),
		retournerHref("?module_id=4&usr_id=".$r["usr_id"], $r["usr_name"]) ,
		$r["nb_views"], $r["nb_downloads"]
		) ;

		}

	$mon_objet->free_result($query_result);

	$module_content .= retournerTableauXY($result);


}
?>


