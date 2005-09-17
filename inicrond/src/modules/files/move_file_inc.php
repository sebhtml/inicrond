<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : changer un download de category
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

else if(isset($_SESSION["sebhtml"]["usr_id"] ) AND
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet) AND
 isset($_GET["uploaded_file_id"]) AND
 $_GET["uploaded_file_id"] != "" AND
 (int) $_GET["uploaded_file_id"]
 ) //admin seulement+nombre naturel valide
{
//

$query = "SELECT
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections.uploaded_files_section_id, 
uploaded_files_section_name,
uploaded_file_title
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].",
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections
WHERE
uploaded_file_id=".$_GET["uploaded_file_id"]."
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections.uploaded_files_section_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].".uploaded_files_section_id
;";

$query_result = $mon_objet->query($query);
$f = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);

	if(isset($f["uploaded_files_section_id"]))//existe -t-il ??
	{
	

	
	//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=1", $_LANG["1"]["titre"]),
	retournerHref("?module_id=5&uploaded_files_section_id=".$f["uploaded_files_section_id"], $f["uploaded_files_section_name"]),
	retournerHref("?module_id=6&uploaded_file_id=".$_GET["uploaded_file_id"], $f["uploaded_file_title"]),
	$_LANG["30"]["titre"]
	);

	// titre
	$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);
	

		if(isset($_POST["uploaded_files_section_id"]) AND
		$_POST["uploaded_files_section_id"] != "" AND
		(int) $_POST["uploaded_files_section_id"]
		)
		{
		//
		
		$query = "UPDATE
	
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."
		SET
		uploaded_files_section_id=".$_POST["uploaded_files_section_id"]."
		WHERE
		uploaded_file_id=".$_GET["uploaded_file_id"]."
		;";

		$query_result = $mon_objet->query($query);
		
		echo js_redir("?module_id=6&uploaded_file_id=".$_GET["uploaded_file_id"]);
		exit();
		}
		else
		{
		$query = "SELECT
		uploaded_files_section_id
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."
		WHERE
		uploaded_file_id=".$_GET["uploaded_file_id"]."
		;";

		$query_result = $mon_objet->query($query);
		$fetch_result = $mon_objet->fetch_assoc($query_result);
		$mon_objet->free_result($query_result);

		$uploaded_files_section_id = $fetch_result["uploaded_files_section_id"];//pour tantoté
			
		include "modules/files/includes/forms/move_file_form_inc.form.php";
		 }
	}




		
}
?>


