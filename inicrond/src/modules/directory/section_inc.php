<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : voir section
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : xoool
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
include "modules/directory/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}
else
{
	if((isset($_GET["directory_section_id"]) AND
	$_GET["directory_section_id"] != "" AND
	(int) $_GET["directory_section_id"]
	))
	
	{
		//-----
		//titre :
		//------
		//$queries["SELECT"] ++; // comptage

		/*
		
DROP TABLE IF EXISTS ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]." ;
#
# Table structure for table '".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]."'
#

CREATE TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]." (
directory_section_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (directory_section_id),

directory_section_name VARCHAR(255) NOT NULL,

right_add_an_url  SMALLINT DEFAULT 0

)TYPE=MyISAM;
#--------------------------------------------------------------------------------------------------------------


*/
		$query = "SELECT
		 directory_section_name 
		FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]."
		WHERE 
		directory_section_id=".$_GET["directory_section_id"]."
		;";

		$query_result = $mon_objet->query($query);


		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);
		
	
//-----------
//titre de la page::
//--------------
$elements_titre = array(
retournerHref("?module_id=38", $_LANG["38"]["titre"]),
$fetch_result["directory_section_name"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


		//--------------
		//la requêtes :
		//-------------
		
		//$queries["SELECT"] ++; // comptage


	
		if(isset($_SESSION["sebhtml"]["usr_id"]) AND
		right_add_an_url($_SESSION["sebhtml"]["usr_id"], $_GET["directory_section_id"], $mon_objet)
		)//ajouter un ifchier
		{
		$module_content .= "<br />";
		$module_content .= retournerHref("?module_id=40&directory_section_id=".$_GET["directory_section_id"],
		$_LANG["40"]["titre"]);

		}
	/*
	
CREATE TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]." (
link_id BIGINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (link_id),

link_title VARCHAR(255) NOT NULL,
link_description TEXT NOT NULL,

link_url VARCHAR(255) NOT NULL,

add_gmt_timestamp BIGINT UNSIGNED  NOT NULL,
edit_gmt_timestamp BIGINT UNSIGNED  NOT NULL,

usr_id BIGINT UNSIGNED NOT NULL,
KEY usr_id (usr_id),

directory_section_id BIGINT UNSIGNED NOT NULL,
KEY directory_section_id (directory_section_id),

nb_hits BIGINT UNSIGNED  DEFAULT 0

)TYPE=MyISAM;

#-----
*/	
	$query = "SELECT 
	link_title, link_id, 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name
	FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE 
	directory_section_id=".$_GET["directory_section_id"]."
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].".usr_id
	ORDER BY 
	edit_gmt_timestamp DESC
	;";
	
	
	}
	
	
	//$uploaded_files_section_id = $_GET["uploaded_files_section_id"];
	
	

	

	

	$query_result = $mon_objet->query($query);
	

	$result = array();

	$result [] = array($_LANG["common"]["title"], $_LANG["4"]["usr_name"],
	 $_LANG["common"]["nb_views"], $_LANG["41"]["nb_hits"]);
	
		while($r = $mon_objet->fetch_assoc($query_result)) 
		{
		$query = "SELECT 
	count(session_id) AS nb_views
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_links"]."
	WHERE
	link_id=".$r["link_id"]."
	;";
	
	$query_result_2 = $mon_objet->query($query);
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	$mon_objet->free_result($query_result_2);

		$r["nb_views"] = $fetch_result["nb_views"];
		
		$query = "SELECT 
	count(session_id) AS nb_hits
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["clicks_for_links"]."
	WHERE
	link_id=".$r["link_id"]."
	;";
	
	$query_result_2 = $mon_objet->query($query);
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	$mon_objet->free_result($query_result_2);

		$r["nb_hits"] = $fetch_result["nb_hits"];
		
		$result[] = array(retournerHref("?module_id=42&link_id=".$r["link_id"],
		 $r["link_title"]),
		retournerHref("?module_id=4&usr_id=".$r["usr_id"], $r["usr_name"]) ,
		$r["nb_views"], $r["nb_hits"]
		) ;

		}

	$mon_objet->free_result($query_result);

	$module_content .= retournerTableauXY($result);


}
?>


