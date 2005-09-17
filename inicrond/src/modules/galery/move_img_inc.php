<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : changer un image de galerie
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

else if(isset($_SESSION["sebhtml"]["usr_id"] ) AND
 is_usr_in_group($_SESSION["sebhtml"]["usr_id"], $_OPTIONS["group_admin"], $mon_objet) AND
 isset($_GET["image_id"]) AND
 $_GET["image_id"] != "" AND
 (int) $_GET["image_id"]
 ) //admin seulement+nombre naturel valide
{


$query = "SELECT
galerie_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
WHERE
image_id=".$_GET["image_id"]."
;";

$query_result = $mon_objet->query($query);
$rows_result = $mon_objet->num_rows($query_result);//nombre de ligne demandées


$mon_objet->free_result($query_result);

	if($rows_result != 0)//existe -t-il ??
	{
	

	$query = "SELECT 
image_title, image_description, file_name,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name,
add_gmt_timestamp, edit_gmt_timestamp,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"].".galerie_id, galerie_name
 
FROM 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."

 WHERE 
 
 image_id=".$_GET["image_id"]."

 AND
 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"].".galerie_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].".galerie_id

AND		

".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"].".usr_id";

$query_result = $mon_objet->query($query);


$r = $mon_objet->fetch_assoc($query_result);

$row_result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);

//titre
//---------------------
//TITRE
//---------------

$elements_titre = array(
retournerHref("?module_id=10", $_LANG["10"]["titre"], "_top", "title"),
retournerHref("?module_id=12&galerie_id=".$r["galerie_id"], $r["galerie_name"]),
retournerHref("?module_id=13&image_id=".$_GET["image_id"],  $r["image_title"]),

 $_LANG["31"]["titre"]
);
$module_title = retourner_titre($elements_titre);

		if(isset($_POST["galerie_id"]) AND
		$_POST["galerie_id"] != "" AND
		(int) $_POST["galerie_id"]
		)
		{
		
		
		$query = "UPDATE
	
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
		SET
		galerie_id=".$_POST["galerie_id"]."
		WHERE
	image_id=".$_GET["image_id"]."
		;";

		$query_result = $mon_objet->query($query);
		
		echo js_redir("?module_id=13&image_id=".$_GET["image_id"]);
		exit();
		}
		//le formulaire
		
		//$queries["SELECT"] ++; // comptage
						
		$query = "SELECT
galerie_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
WHERE
image_id=".$_GET["image_id"]."
;";

$query_result = $mon_objet->query($query);
$rows_result = $mon_objet->num_rows($query_result);//nombre de ligne demandées

$fetch_result = $mon_objet->fetch_assoc($query_result);

$galerie_id = $fetch_result["galerie_id"];//ppour tantôt

$mon_objet->free_result($query_result);


		include "modules/galery/includes/forms/move_an_img.form.php";
	}




		
}
?>


