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
include "modules/galery/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

if(isset($_SESSION["sebhtml"]["usr_id"]))
{



	/*
	0 add
	1 edit
	2 rm
	*/

	

	if(isset($_GET["galerie_id"]) AND
	$_GET["galerie_id"] != "" AND
	(int) $_GET["galerie_id"] AND
	right_add_an_img($_SESSION["sebhtml"]["usr_id"], $_GET["galerie_id"], $mon_objet)
	)
	//add
	{
		

$query = "SELECT 
		galerie_name 
		FROM 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
		WHERE 
		galerie_id=".$_GET["galerie_id"]."
		;";
			$query_result = $mon_objet->query($query);
			
			
		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$mon_objet->free_result($query_result);
		
		
$elements_titre = array(
retournerHref("?module_id=10", $_LANG["10"]["titre"]),
retournerHref("?module_id=12&galerie_id=".$_GET["galerie_id"], $fetch_result["galerie_name"]),

$_LANG["18"]["titre"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);



		$query = "SELECT
		 galerie_id
		  FROM 
		  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
		  WHERE 
		  galerie_id=".$_GET["galerie_id"]."
		  ";

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

		$uploaded_file_name_value = "" ;
		$uploaded_file_description_value = "" ;
		include "modules/galery/includes/forms/file_inc.form.php";
		}
		else // il y a eu envoi de données
		{

			if(!is_file($_FILES['uploaded_file_url']['tmp_name']))
			{
			$module_content .= $_LANG["15"]["error_file"];
			//return;
			}
			else
			{
			

		$file_name = filter($_FILES['uploaded_file_url']['name']);



		$image_title = ($_POST["image_title"] != "") ? filter($_POST["image_title"]) : $file_name;
		
		//$image_description = filter($_POST["uploaded_file_description"]);

		$add_gmt_timestamp = gmmktime();

	

		$query = "INSERT 
		INTO 
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
		(
	image_title,
	image_description,
	file_name,
	add_gmt_timestamp,
	edit_gmt_timestamp,
	usr_id,
	galerie_id
	) VALUES (
	'$image_title',
	'".filter($_POST["image_description"])."',
	'$file_name',
	$add_gmt_timestamp,
	$add_gmt_timestamp,
	". $_SESSION["sebhtml"]["usr_id"].",
	".$_GET["galerie_id"]."
	)";

	$mon_objet->query($query);
		


		$uploaded_file_id = $mon_objet->insert_id();

		$uploaded_file_url = $_OPTIONS["file_path"]["images_dir"]."/".$uploaded_file_id;
	
				if(!copy($_FILES['uploaded_file_url']['tmp_name'], $uploaded_file_url))
				{
				$module_content .= $_LANG["15"]["error_file"];
				//return;
				}
				else
				{
				echo js_redir("?module_id=12&galerie_id=".
				$_GET["galerie_id"]);
				exit();
				}
			}
		}
	}
	elseif($_GET["mode_id"] == 1 AND
	isset($_GET["image_id"]) AND
	$_GET["image_id"] != "" AND
	(int) $_GET["image_id"]
	) //edit
	{



$query = "SELECT 
image_title,

".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"].".galerie_id,
 galerie_name
 
FROM 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."

 WHERE 
 
 image_id=".$_GET["image_id"]."

 AND
 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"].".galerie_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].".galerie_id

";

$query_result = $mon_objet->query($query);


$r = $mon_objet->fetch_assoc($query_result);

$row_result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);

if($row_result != 1)
{
echo js_redir("./");

}

		

//---------------------
//TITRE
//---------------

$elements_titre = array(
retournerHref("?module_id=10", $_LANG["10"]["titre"], "_top", "title"),
retournerHref("?module_id=12&galerie_id=".$r["galerie_id"], $r["galerie_name"]),
retournerHref("?module_id=13&image_id=".$_GET["image_id"],  $r["image_title"]),

 $_LANG["common"]["edit"]
);


// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

		
		


		//--------------
		// existe-il ?? le file
		//-------------
		
		$query = "SELECT 
		usr_id, image_title,
		 image_description 
		 FROM 
		 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
		 WHERE
		  image_id=".$_GET["image_id"]."
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
		$uploaded_file_title_value = $fetch_result["image_title"];
		$uploaded_file_description_value = $fetch_result["image_description"] ;

		include "modules/galery/includes/forms/file_inc.form.php";
		}
		else // envoi
		{

		$query = "UPDATE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]." 
				SET ";
			
				/*	
			if(isset($_POST["new_file"] ) ) // che ck box
			{
			*/
			if(is_file($_FILES['uploaded_file_url']['tmp_name']) AND
			fileSize($_FILES['uploaded_file_url']['tmp_name']) != 0
			)
			{
				

				copy($_FILES['uploaded_file_url']['tmp_name'], 
				$_OPTIONS["file_path"]["images_dir"]."/".$_GET["image_id"]);
				
				
				
				$uploaded_file_name = filter($_FILES['uploaded_file_url']['name']);
				
				$query .= 	"file_name='$uploaded_file_name',";
			}
			
			{//requete sql...

				$uploaded_file_title = ($_POST["image_title"] != "") ? filter($_POST["image_title"]) : $uploaded_file_name ;
		//		$uploaded_file_description = filter($_POST["uploaded_file_description"]);

			if($uploaded_file_title != "")
			{
			$query .= "

				image_title='$uploaded_file_title',
				";		
			}

			//	$uploaded_file_edit_gmt_timestamp = gmmktime();

				
				
				$query .= "

				
				image_description='". filter($_POST["image_description"])."',
				edit_gmt_timestamp='".gmmktime()."'

				WHERE
				image_id=".$_GET["image_id"]."
				";

				 $mon_objet->query($query);

	echo js_redir("?module_id=13&image_id=".
		$_GET["image_id"]);
		

exit();

			}
		}


	}


	elseif($_GET["mode_id"] == 2 AND
	 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND
	 isset($_GET["image_id"]) AND
	 $_GET["image_id"] != "" AND
	 (int) $_GET["image_id"]
	 )// remove
	{




	


$query = "SELECT 
image_title,

".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"].".galerie_id,
 galerie_name
 
FROM 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."

 WHERE 
 
 image_id=".$_GET["image_id"]."

 AND
 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"].".galerie_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].".galerie_id

";

$query_result = $mon_objet->query($query);


$r = $mon_objet->fetch_assoc($query_result);

$row_result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);

if($row_result != 1)
{
echo js_redir("./");

}

		

//---------------------
//TITRE
//---------------

$elements_titre = array(
retournerHref("?module_id=10", $_LANG["10"]["titre"], "_top", "title"),
retournerHref("?module_id=12&galerie_id=".$r["galerie_id"], $r["galerie_name"]),
retournerHref("?module_id=13&image_id=".$_GET["image_id"],  $r["image_title"]),

$_LANG["common"]["remove"]
);


// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


		
				
		$query = "SELECT
		 usr_id
		  FROM 
		  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
		   WHERE
		    image_id=". $_GET["image_id"]."
		    ";

		$query_result = $mon_objet->query($query);

		$fetch_result = $mon_objet->fetch_assoc($query_result);

		$num_row = $mon_objet->num_rows($query_result);

		$mon_objet->free_result($query_result);
				
		if($num_row == 1)//si la source existe pas
		{


		

			if(isset($_GET["ok"])) // on enlève
			{
			
			//$queries["DELETE"] ++; // comptage
			
			$query = "DELETE FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
			 WHERE 
			 image_id=". $_GET["image_id"]."
			 ";


			$query_result = $mon_objet->query($query);

echo js_redir("?module_id=12&galerie_id=".$r["galerie_id"]);//redirection
exit();

			}
			else
			{

			$module_content .= retournerHref("?module_id=18&mode_id=2&image_id=".$_GET["image_id"]."&ok",
			 $_LANG["common"]["remove"]);
			}
		
		}
	}

}
?>


