<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : add/edit/rm uploaded file
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

if(isset($_SESSION["sebhtml"]["usr_id"]) 
)//ajouter un fichier.
{

$module_title = "";
$module_content  = "";


	/*
	0 add
	1 edit
	2 rm
	*/

	if(!isset($_GET["mode_id"]))
	{
	$_GET["mode_id"] = 0;
	}

	if($_GET["mode_id"] == 0 AND
right_add_a_file($_SESSION["sebhtml"]["usr_id"], $_GET["uploaded_files_section_id"], $mon_objet)) //add
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

$_LANG["15"]["add"]
);


// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);



		$uploaded_files_section_id = $_GET["uploaded_files_section_id"];
//$queries["SELECT"] ++; // comptage
		$query = "SELECT
		 uploaded_files_section_id
		  FROM 
		  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections 
		  WHERE 
		  uploaded_files_section_id=$uploaded_files_section_id";

		$query_result = $mon_objet->query($query);

		$rows_result = $mon_objet->num_rows($query_result);

		$mon_objet->free_result($query_result);

		if($rows_result != 1)//est ce que la section existe ??
		{
		echo js_redir("./");
		exit();
		}

		if(!isset($_POST["envoi"]))
		{
		$edit = FALSE;
		$uploaded_file_name_value = "" ;
		$uploaded_file_description_value = "" ;
		include "modules/files/includes/forms/file_inc.form.php";
		}
		else // il y a eu envoi de données
		{
/*
		
*/
		if(!is_file($_FILES['uploaded_file_url']['tmp_name']))
		{
		$module_content .= $_LANG["15"]["error_file"];
		return;
		}

		

		$uploaded_file_name = filter($_FILES['uploaded_file_url']['name']);







		$uploaded_file_title = ($_POST["uploaded_file_title"] != "") ?  filter($_POST["uploaded_file_title"]) :  $uploaded_file_name ;
		$uploaded_file_description = filter($_POST["uploaded_file_description"]);

		$uploaded_file_add_gmt_timestamp = gmmktime();

		$uploaded_file_edit_gmt_timestamp = gmmktime();

		$usr_id = $_SESSION["sebhtml"]["usr_id"];


		$query = "INSERT INTO ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."
		(

	uploaded_file_title,
	uploaded_file_description,


	uploaded_file_name,

	uploaded_file_add_gmt_timestamp,
	uploaded_file_edit_gmt_timestamp,

	usr_id,

	uploaded_files_section_id
	) VALUES (

	'$uploaded_file_title',
	'$uploaded_file_description',

	
	'$uploaded_file_name',

	$uploaded_file_add_gmt_timestamp,
	$uploaded_file_edit_gmt_timestamp,

	$usr_id,

	$uploaded_files_section_id

	)
	";

		if(!$mon_objet->query($query))
		{
		die($mon_objet->error());
		}



		$uploaded_file_id = $mon_objet->insert_id();

		$uploaded_file_url = $_OPTIONS["uploaded_files_dir"]."/".$uploaded_file_id;

		if(!copy($_FILES['uploaded_file_url']['tmp_name'], $uploaded_file_url))
		{
		$module_content .= $_LANG["15"]["error_file"];
		return;
		}
		echo js_redir("?module_id=5&uploaded_files_section_id=".
		$_GET["uploaded_files_section_id"]);
	exit();

		}
	}
	elseif($_GET["mode_id"] == 1 AND
	isset($_GET["uploaded_file_id"]) AND
	$_GET["uploaded_file_id"] != "" AND
	(int) $_GET["uploaded_file_id"]
	) //edit
	{


$query = "SELECT 
uploaded_file_title, 
uploaded_files_section_name,
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files_sections"].".uploaded_files_section_id
FROM 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files_sections"]."

 WHERE 
 
 uploaded_file_id=".$_GET["uploaded_file_id"]."

 AND
 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files_sections"].".uploaded_files_section_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].".uploaded_files_section_id
";


$query_result = $mon_objet->query($query);

$r = $mon_objet->fetch_assoc($query_result);



$mon_objet->free_result($query_result);
//---------------------
//TITRE
//---------------
//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=1", $_LANG["1"]["titre"]),
	retournerHref("?module_id=5&uploaded_files_section_id=".$r["uploaded_files_section_id"], $r["uploaded_files_section_name"]),
		retournerHref("?module_id=6&uploaded_file_id=".$_GET["uploaded_file_id"], $r["uploaded_file_title"]),
		
	
	$_LANG["15"]["edit"]
	);

	// titre
	$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

	
		
		

		$uploaded_file_id = $_GET["uploaded_file_id"];



		//--------------
		// existe-il ?? le file
		//-------------
		
		$queries["SELECT"] ++; // comptage
		
		$query = "SELECT 
		usr_id, uploaded_file_title,
		 uploaded_file_description 
		 FROM 
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]." 
		 WHERE
		  uploaded_file_id=$uploaded_file_id
		  ";

		$query_result = $mon_objet->query($query);


		$num_row = $mon_objet->num_rows($query_result);

		if($num_row != 1)//si la source existe pas
		{

		echo js_redir("./");
		exit();
		}

		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);


		if($_SESSION["sebhtml"]["usr_id"] != $fetch_result["usr_id"])// juste l'auteur peut éditer
		{
		header("Location ./");
		exit();
		}
		else if(!isset($_POST["envoi"]))
		{
		//$edit = TRUE;
		$uploaded_file_title_value = $fetch_result["uploaded_file_title"];
		$uploaded_file_description_value = $fetch_result["uploaded_file_description"] ;

		include "modules/files/includes/forms/file_inc.form.php";
		}
		else // envoi
		{

		
		$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]." 
				SET ";
				
				
				$error = FALSE;
				
			if(is_file($_FILES['uploaded_file_url']['tmp_name']) AND
			fileSize($_FILES['uploaded_file_url']['tmp_name']) != 0
			)
			{
				
				
copy($_FILES['uploaded_file_url']['tmp_name'], 
				$_OPTIONS["uploaded_files_dir"]."/".$uploaded_file_id);
				
				$uploaded_file_name = filter($_FILES['uploaded_file_url']['name']);
				
				$query .= 	"uploaded_file_name='$uploaded_file_name',";
				
			}
			
			

			//si la chaine est vide, c'est le nom du fichier.
				$uploaded_file_title = ($_POST["uploaded_file_title"] != "") ? filter($_POST["uploaded_file_title"]) : $uploaded_file_name;
				
				//$uploaded_file_description = ;


				//$uploaded_file_edit_gmt_timestamp = gmmktime();

				if($uploaded_file_title != "")
				{
				$query .= "
					uploaded_file_title='$uploaded_file_title',";
				}
				
				$query .= "

			
				uploaded_file_description='".filter($_POST["uploaded_file_description"])."',
				uploaded_file_edit_gmt_timestamp='".gmmktime()."'

				WHERE
				uploaded_file_id=$uploaded_file_id
				";

			 $mon_objet->query($query);

	echo js_redir("?module_id=6&uploaded_file_id=".
		$_GET["uploaded_file_id"]);
		exit();

			


		}


	}


	elseif($_GET["mode_id"] == 2 AND
	 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND
	 isset($_GET["uploaded_file_id"]) AND
	 $_GET["uploaded_file_id"] != "" AND
	 (int) $_GET["uploaded_file_id"]
	 )// remove
	{


		

$query = "SELECT 
uploaded_file_title, 
uploaded_files_section_name,
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files_sections"].".uploaded_files_section_id
FROM 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files_sections"]."

 WHERE 
 
 uploaded_file_id=".$_GET["uploaded_file_id"]."

 AND
 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files_sections"].".uploaded_files_section_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].".uploaded_files_section_id
";


$query_result = $mon_objet->query($query);

$r = $mon_objet->fetch_assoc($query_result);



$mon_objet->free_result($query_result);
//---------------------
//TITRE
//---------------
//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=1", $_LANG["1"]["titre"]),
	retournerHref("?module_id=5&uploaded_files_section_id=".$r["uploaded_files_section_id"], $r["uploaded_files_section_name"]),
		retournerHref("?module_id=6&uploaded_file_id=".$_GET["uploaded_file_id"], $r["uploaded_file_title"]),
		
	
$_LANG["15"]["rm"]
	);

	// titre
	$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

	
		
//---
		$uploaded_file_id = $_GET["uploaded_file_id"];

		//--------------
		// existe-il ??
		//-------------
	
				
		$query = "SELECT usr_id FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]." WHERE uploaded_file_id=$uploaded_file_id";

		$query_result = $mon_objet->query($query);

		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$num_row = $mon_objet->num_rows($query_result);

		if($num_row == 1)//si la source existe pas
		{


		



		$mon_objet->free_result($query_result);

			if(isset($_GET["ok"])) // on enlève
			{
			
			$query = "DELETE FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]." WHERE uploaded_file_id=$uploaded_file_id";


			$query_result = $mon_objet->query($query);
			
			
echo js_redir("?module_id=5&uploaded_files_section_id=".
		$r["uploaded_files_section_id"]);
	exit();
			//$module_content .= $_LANG["15"]["enregistrer"];
			}
			else
			{

			$module_content .= retournerHref("?module_id=15&mode_id=2&uploaded_file_id=$uploaded_file_id&ok",
			 $_LANG["15"]["remove_now"]);
			}
		
		}
	}

}
?>


