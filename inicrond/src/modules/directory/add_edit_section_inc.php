<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : add/edit file section
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
include "modules/directory/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}




if(isset($_SESSION["sebhtml"]["usr_id"] ) AND
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet)) //admin seulement
{



	if(!isset($_GET["mode_id"]))
	{
	$_GET["mode_id"] = 0 ;
	}

	if($_GET["mode_id"] == 0)
	{
	

		


	//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=38", $_LANG["38"]["titre"]),
	$_LANG["39"]["titre"]
	);
	
	/*		
$elements_titre = array(
$_LANG["39"]["titre"]
);
*/
// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

		if(!isset($_POST["envoi"]))
		{

		$uploaded_files_section_name_value = "";

		include "modules/directory/includes/forms/section_inc.form.php";
		}
		else
		{



		$uploaded_files_section_name = filter($_POST["uploaded_files_section_name"]);

	
		$query = "INSERT INTO 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]."
		(
		directory_section_name,
		right_add_an_url
		)
		VALUES
		(
		'$uploaded_files_section_name',
		".$_POST["right_add_a_file"]."
		)";

			if($mon_objet->query($query))
			{
			echo js_redir("?module_id=38");
			exit();
			}
			else
			{
			$module_content .= $mon_objet->error();
			}
		}
	}
	else if($_GET["mode_id"] == 1 AND
	isset($_GET["directory_section_id"]) AND
	$_GET["directory_section_id"] != "" AND
	(int) $_GET["directory_section_id"]
	)
	{

		
	
	
$query = "SELECT 


directory_section_name
 FROM
  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]."
 WHERE 
  directory_section_id=". $_GET["directory_section_id"]."
 ";

$query_result = $mon_objet->query($query);


$r = $mon_objet->fetch_assoc($query_result);

//$row_result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);


	//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=38", $_LANG["38"]["titre"]),
	retournerHref("?module_id=41&directory_section_id=".$_GET["directory_section_id"], $r["directory_section_name"]),
	
	
$_LANG["common"]["edit"]
	);



// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

			//--------------
			// existe-il ??
			//-------------

			$uploaded_files_section_id = $_GET["directory_section_id"];

			$query = "SELECT 
			directory_section_id, directory_section_name,
			 right_add_an_url
			 FROM 
			 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]."
			  WHERE
			   directory_section_id=".$_GET["directory_section_id"]."";

			$query_result = $mon_objet->query($query);


			$num_row = $mon_objet->num_rows($query_result);

			if($num_row != 1)//si existe pas
			{

			return;
			}

			$fetch_result = $mon_objet->fetch_assoc($query_result);

			$mon_objet->free_result($query_result);


			if(!isset($_POST["envoi"]))
			{
			$uploaded_files_section_name_value = $fetch_result["directory_section_name"];
		$right_add_a_file = $fetch_result["right_add_an_url"];

		include "modules/directory/includes/forms/section_inc.form.php";
				
			}
			else
			{



			$uploaded_files_section_name = filter($_POST["uploaded_files_section_name"]);


			$query = "UPDATE
			 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]."
			SET
			directory_section_name='$uploaded_files_section_name',
			right_add_an_url=".$_POST["right_add_a_file"]."
			WHERE
			directory_section_id=".$_GET["directory_section_id"]."
			";

				if($mon_objet->query($query))
				{
				echo js_redir("?module_id=38");
				exit();
				}
				else
				{
				$module_content .= $mon_objet->error();
				}
			}

		
	
	}

}
?>


