<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : view img
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
//
//--------------------
include "modules/galery/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

if(isset($_GET["image_id"]) AND
$_GET["image_id"] != "" AND
(int) $_GET["image_id"]
)
{
if(!preg_match($_OPTIONS["preg_agent"], $_SERVER["HTTP_USER_AGENT"]))
		{	
		$query = "
		INSERT
		INTO
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_images"]."
		(session_id, image_id, gmt_timestamp)
		VALUES
		(".$_SESSION["sebhtml"]["session_id"].", ".$_GET["image_id"].", ".gmmktime().")
		";

		$mon_objet->query($query);
		
		/*$query = "
		UPDATE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
		SET
		nb_views=nb_views+1
		WHERE
		image_id=".$_GET["image_id"]."
		;";

		$query_result = $mon_objet->query($query);
		*/
		}
//$uploaded_file_id = $_GET["uploaded_file_id"];
/*
CREATE TABLE ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]." (
image_id SMALLINT UNSIGNED AUTO_INCREMENT,
PRIMARY KEY (image_id),

image_title VARCHAR(255) NOT NULL,
image_description TEXT NOT NULL,

file_name VARCHAR(255) NOT NULL,

add_gmt_timestamp BIGINT UNSIGNED  NOT NULL,
edit_gmt_timestamp BIGINT UNSIGNED  NOT NULL,

usr_id SMALLINT UNSIGNED NOT NULL,
KEY usr_id (usr_id),

galerie_id SMALLINT UNSIGNED NOT NULL,
KEY galerie_id (galerie_id)

);

*/
	//$queries["SELECT"] ++; // comptage

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

if($row_result != 1)
{
echo js_redir("./");

}

		

//---------------------
//TITRE
//---------------

$elements_titre = array(
retournerHref("?module_id=10", $_LANG["10"]["titre"], "_top", "title"),
retournerHref("?module_id=12&galerie_id=".$r["galerie_id"],
 $r["galerie_name"]),
 $r["image_title"]
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

	
	if(isset($_SESSION["sebhtml"]["usr_id"]) AND
	 $_SESSION["sebhtml"]["usr_id"] == $r["usr_id"] )
	{
	$module_content .= "<br />";

	$module_content .= retournerHref("?module_id=18&mode_id=1&image_id=".$_GET["image_id"],
	 $_LANG["common"]["edit"]);

	}

	
	if(isset($_SESSION["sebhtml"]["usr_id"]) AND
	  is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet) )
	{
	$module_content .= "<br />";

	$module_content .= retournerHref("?module_id=18&mode_id=2&image_id=".$_GET["image_id"],
	 $_LANG["common"]["remove"]);
$module_content .= "<br />";

	$module_content .= retournerHref("?module_id=31&image_id=".$_GET["image_id"],
	$_LANG["31"]["titre"]);

	}





	$module_content .= "<p align=\"center\">";

		$queries["SELECT"] ++; // comptage dans download
		
	$module_content .= "<img src=\"download.php?image_id=".$_GET["image_id"]."\" /><br />"; 
	
	$module_content .= $r["file_name"] ;
	
	
	$module_content .= "<br />";
	
$image_info = getimagesize($_OPTIONS["images_dir"]."/".$_GET["image_id"]);

//print_r($image_info);
//exit();

$tableau = array();



$tableau[] = array($_LANG["13"]["size"], filesize($_OPTIONS["images_dir"]."/".$_GET["image_id"]));

$tableau[] = array($_LANG["13"]["width"], $image_info["0"]);

$tableau[] = array($_LANG["13"]["height"], $image_info["1"]);

$tableau[] = array($_LANG["13"]["bits"], $image_info["bits"]);

$tableau[] = array($_LANG["13"]["channels"], $image_info["channels"]);

$module_content .= retournerTableauXY($tableau);

	$module_content .= "<br />";
		
		$image = "";
	
	if(is_file($_OPTIONS["usrs_pics"]."/".$r["usr_id"]))
	{
	$image =
"<br /><img src=\"download.php?usrs_pics=".$r["usr_id"]."\" />";

	}
	$module_content .= retournerHref("?module_id=4&usr_id=".$r["usr_id"], $r["usr_name"].$image) ;
		
	$module_content .= "</p>";

//	include "includes/fonctions/cbparser.php";//parser BBcode
	
		$module_content .= "<p align=\"justify\">";
	$module_content .= bb2html($r["image_description"], "");
	
		$module_content .= "</p>";


$module_content .= $_LANG["common"]["add_date"];

$module_content .= " : ";
$gm_timestamp = $r['add_gmt_timestamp'];

$module_content .=  format_time_stamp($gm_timestamp, $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);


	if($r['add_gmt_timestamp'] != $r['edit_gmt_timestamp'])
	{
	$module_content .= "<br />";
	$module_content .= $_LANG["common"]["modif_date"];
	$module_content .= " : ";
	
	$gm_timestamp = $r['edit_gmt_timestamp'];
	
	$module_content .=  format_time_stamp($gm_timestamp, $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);
	}
	

//début du graphique
//
/*

CREATE TABLE views_of_files (

session_id BIGINT UNSIGNED,
KEY session_id (session_id),

uploaded_file_id BIGINT UNSIGNED,
KEY uploaded_file_id (uploaded_file_id),

gmt_timestamp BIGINT UNSIGNED 

)TYPE=MyISAM
*/	
	
$sql = "
SELECT 

gmt_timestamp

FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_images"]."
WHERE
image_id=".$_GET["image_id"]."
";
$r = $mon_objet->query($sql);
	
	$Calib_curve_data = array();
	//$donnees = array();//données statistiques
/*
$data = array(
		ar40ray(
			"x" => "y",
			"x" => "y"
			
			),
		array(
			"x" => "y",
			"x" => "y"
			)
);
*/
	while($f = $mon_objet->fetch_assoc($r))
	{
	
	//pour la droite de calibration...
		if(isset($Calib_curve_data[($f["gmt_timestamp"]/(60*60*24))]))//est-ce que la date est déjà enregistrée?
		{
		$Calib_curve_data[($f["gmt_timestamp"]/(60*60*24))] ++;//on augmente le nombre de visite pour cette journée.
		}
		else
		{
		$Calib_curve_data[($f["gmt_timestamp"]/(60*60*24))] = 1;
		}
	}//fin du while
	
	$mon_objet->free_result($r);
	
		//$Calib_curve_data = array(500=>5, 550=>50,600=>15);
	
//trouve les zéro et les mets à zzéro
	$les_x = array_keys($Calib_curve_data);
	
	$min_x = min($les_x);
	
	$max_x = max($les_x);
/*	
echo "max_x = $max_x<br />";
echo "min_x = $min_x<br />";
*/
	for($i = $min_x ; $i < $max_x ; $i++)
	{
	
		if(!isset($Calib_curve_data[$i]))
		{
		$Calib_curve_data[$i] = 0;
		}
	
	}
	$les_x = array_keys($Calib_curve_data);
//trier les affaires dans le tableau.
sort($les_x);
$new_tab =  array();


 
foreach($les_x AS $key)
{
$new_tab[$key] = $Calib_curve_data[$key];
}
$Calib_curve_data = $new_tab;

//sort($Calib_curve_data);

	$bob = array();
	
	$bob []= $Calib_curve_data;

$_SESSION["sebhtml"]["calib_curve"] = $bob;

//echo nl2br(print_r($_SESSION["sebhtml"]["calib_curve"], TRUE));//debug

$module_content .= "<br />";
$module_content .= "<br />";
$module_content .= $_LANG["13"]["curve"];

$module_content .= "<br /><img src=\"download.php?calib_curve\" />";

//fin du graphique

	
	
}

?>


