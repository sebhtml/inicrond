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
include "modules/files/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
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
	

			
$elements_titre = array(
retournerHref("?module_id=1", $_LANG["1"]["titre"]),
$_LANG["17"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

		if(!isset($_POST["envoi"]))
		{

		$uploaded_files_section_name_value = "";

		include "modules/files/includes/forms/section_inc.form.php";
		}
		else
		{



		$uploaded_files_section_name = filter($_POST["uploaded_files_section_name"]);

		$query = "INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections
		(
		uploaded_files_section_name,
		right_add_a_file
		)
		VALUES
		(
		'$uploaded_files_section_name',
		".$_POST["right_add_a_file"]."
		)";

			if($mon_objet->query($query))
			{
			echo js_redir("?module_id=1");
						exit();
				}
			else
			{
			$module_content .= $mon_objet->error();
			}
		}
	}
	else if($_GET["mode_id"] == 1 AND
	isset($_GET["uploaded_files_section_id"]) AND
	$_GET["uploaded_files_section_id"] != "" AND
	(int) $_GET["uploaded_files_section_id"]
	)
	{

		
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
retournerHref("?module_id=5&uploaded_files_section_id=".$_GET["uploaded_files_section_id"], $fetch_result["uploaded_files_section_name"]),

$_LANG["5"]["edit"]
);



// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

			//--------------
			// existe-il ??
			//-------------

			$uploaded_files_section_id = $_GET["uploaded_files_section_id"];

			$query = "SELECT uploaded_files_section_id, uploaded_files_section_name,
			 right_add_a_file
			 FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections WHERE uploaded_files_section_id=". $_GET["uploaded_files_section_id"]."";

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
			$uploaded_files_section_name_value = $fetch_result["uploaded_files_section_name"];
		$right_add_a_file = $fetch_result["right_add_a_file"];
		
		include "modules/files/includes/forms/section_inc.form.php";
			}
			else
			{


			$uploaded_files_section_name = filter($_POST["uploaded_files_section_name"]);

			$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections
			SET
			uploaded_files_section_name='$uploaded_files_section_name',
			right_add_a_file=".$_POST["right_add_a_file"]."
			WHERE
			uploaded_files_section_id=$uploaded_files_section_id
			";

				if($mon_objet->query($query))
				{
				echo js_redir("?module_id=1");
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


