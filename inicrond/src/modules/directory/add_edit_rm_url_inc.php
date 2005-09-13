<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : add/edit/rm url
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
right_add_an_url($_SESSION["sebhtml"]["usr_id"], $_GET["directory_section_id"], $mon_objet)) //add
	{

//---------------------
//TITRE
//---------------

	
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
	
	
$_LANG["40"]["titre"]
	);


// titre
$module_title = retourner_titre($elements_titre);		




		$uploaded_files_section_id = $_GET["directory_section_id"];
//$queries["SELECT"] ++; // comptage
		$query = "SELECT
		 directory_section_id
		  FROM 
		  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]." 
		  WHERE 
		  directory_section_id=".$_GET["directory_section_id"]."";

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
		
		$fetch_result["link_url"] = "http://";
		
		include "modules/directory/includes/forms/url.form.php";
		}
		else // il y a eu envoi de données
		{

		if($_POST["link_title"] == "")
		{
		$module_content .= $_LANG["16"]["empty"];
		
		}
		elseif(!strstr($_POST["link_url"], "http://"))
		{
		$module_content .= $_LANG["11"]["error_website"];
		}
		else
			{

		

		
$gmmktime = gmmktime();
		$query = "
		INSERT INTO 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]."
		(
	link_title,
	link_description,
	link_url,
	add_gmt_timestamp,
	edit_gmt_timestamp,
	usr_id,
	directory_section_id
	) VALUES (
	'".filter($_POST["link_title"])."',
	'".filter($_POST["link_description"])."',
		'".filter($_POST["link_url"])."',
	".$gmmktime.",
	".$gmmktime.",
	".$_SESSION["sebhtml"]["usr_id"].",
	".$_GET["directory_section_id"]."
	)
	";

		$mon_objet->query($query);
		
		

		echo js_redir("?module_id=41&directory_section_id=".$_GET["directory_section_id"]);
		exit();
		
			}
		}
	}
	elseif($_GET["mode_id"] == 1 AND
	isset($_GET["link_id"]) AND
	$_GET["link_id"] != "" AND
	(int) $_GET["link_id"]
	) //edit
	{

	//-------------------

//---------------------
//TITRE
//---------------

	
$query = "SELECT 
link_title, 
link_description, 

".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id,
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name,
add_gmt_timestamp,
 edit_gmt_timestamp,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"].".directory_section_id, 
directory_section_name
 FROM
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
 WHERE 
  link_id=". $_GET["link_id"]."
 AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"].".directory_section_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].".directory_section_id
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].".usr_id
;";

$query_result = $mon_objet->query($query);


$r = $mon_objet->fetch_assoc($query_result);

//$row_result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);


	//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=38", $_LANG["38"]["titre"]),
	retournerHref("?module_id=41&directory_section_id=".$r["directory_section_id"], $r["directory_section_name"]),
		retournerHref("?module_id=42&link_id=".$_GET["link_id"], $r["link_title"]),
		
	
	$_LANG["common"]["edit"]
	);


// titre
$module_title = retourner_titre($elements_titre);		

		
		
		

		$uploaded_file_id = $_GET["link_id"];



		
		
		$query = "SELECT 
		usr_id, link_title, link_url,
		 link_description 
		 FROM 
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]." 
		 WHERE
		  link_id=".$_GET["link_id"]."
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
		include "modules/directory/includes/forms/url.form.php";
		}
		else // envoi
		{

		
		$query = "UPDATE 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]." 
				SET ";
				
			
				$query .= "
					link_title='".filter($_POST["link_title"])."',";
				$query .= "

				
				link_url='".filter($_POST["link_url"])."',
				link_description='".filter($_POST["link_description"])."',
				edit_gmt_timestamp='".gmmktime()."'

				WHERE
	  link_id=".$_GET["link_id"]."
				";

			 $mon_objet->query($query);

	echo js_redir("?module_id=42&link_id=".
		$_GET["link_id"]);
		
exit();

		}


	}


	elseif($_GET["mode_id"] == 2 AND
	 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND
	 isset($_GET["link_id"]) AND
	 $_GET["link_id"] != "" AND
	 (int) $_GET["link_id"]
	 )// remove
	{


		

//---------------------
//TITRE
//---------------

	
$query = "SELECT 
link_title, 
link_description, 

".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id,
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name,
add_gmt_timestamp,
 edit_gmt_timestamp,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"].".directory_section_id, 
directory_section_name
 FROM
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
 WHERE 
  link_id=". $_GET["link_id"]."
 AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"].".directory_section_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].".directory_section_id
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"].".usr_id
;";

$query_result = $mon_objet->query($query);


$r = $mon_objet->fetch_assoc($query_result);

//$row_result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);


	//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=38", $_LANG["38"]["titre"]),
	retournerHref("?module_id=41&directory_section_id=".$r["directory_section_id"], $r["directory_section_name"]),
		retournerHref("?module_id=42&link_id=".$_GET["link_id"], $r["link_title"]),
		
	
	$_LANG["common"]["remove"]
	);


// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);		

		$uploaded_file_id = $_GET["link_id"];

		//--------------
		// existe-il ??
		//-------------
		
	//$queries["SELECT"] ++; // comptage
				
		$query = "SELECT usr_id FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]."
		 WHERE 
		 link_id=".$_GET["link_id"]."";

		$query_result = $mon_objet->query($query);

		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$num_row = $mon_objet->num_rows($query_result);
$mon_objet->free_result($query_result);
		if($num_row == 1)//si la source existe pas
		{


		



		

			if(isset($_GET["ok"])) // on enlève
			{
			
		
			
			$query = "DELETE FROM 
			".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]."
			WHERE
		 link_id=".$_GET["link_id"].";";


			$query_result = $mon_objet->query($query);

			echo js_redir("?module_id=41&directory_section_id=".$r["directory_section_id"]);
			exit();
			
			
			//$module_content .= $_LANG["15"]["enregistrer"];
			}
			else
			{

			$module_content .= retournerHref("?module_id=40&mode_id=2&link_id=".$_GET["link_id"]."&ok",
			 $_LANG["common"]["remove"]);
			}
		
		}
	}

}
?>


