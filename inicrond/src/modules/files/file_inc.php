<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : view uploaded file
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
include "modules/files/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

if(isset($_GET["uploaded_file_id"]) AND
$_GET["uploaded_file_id"] != "" AND
(int) $_GET["uploaded_file_id"]
)
{

$uploaded_file_id = $_GET["uploaded_file_id"];

	

$query = "SELECT 
uploaded_file_title, uploaded_file_description, uploaded_file_name,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name,
uploaded_file_add_gmt_timestamp, uploaded_file_edit_gmt_timestamp,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections.uploaded_files_section_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections.uploaded_files_section_name
 
FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."

 WHERE 
 
 uploaded_file_id=$uploaded_file_id

 AND
 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections.uploaded_files_section_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].".uploaded_files_section_id

AND

".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"].".usr_id";

if(!$query_result = $mon_objet->query($query))
{
die($mon_objet->error());
}

$r = $mon_objet->fetch_assoc($query_result);

$row_result = $mon_objet->num_rows($query_result);

$mon_objet->free_result($query_result);

if($row_result == 1)
	{
	//echo js_redir("./");

if(!preg_match($_OPTIONS["preg_agent"], $_SERVER["HTTP_USER_AGENT"]))
	{
	
			
		$query = "
		INSERT
		INTO
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_files"]."
		(session_id, uploaded_file_id, gmt_timestamp)
		VALUES
		(".$_SESSION["sebhtml"]["session_id"].", ".$_GET["uploaded_file_id"].", ".gmmktime().")
		";
//die($tmp);

		$mon_objet->query($query);
			
		/*
		$query = "
		INSERT
		INTO
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_files"]."
		(session_id, uploaded_file_id, gmt_timestamp)
		VALUES
		(".$_SESSION["sebhtml"]["session_id"].", ".$_GET["uploaded_file_id"].", ".(gmmktime()+24*60*60*60).")
		";
//die($tmp);

		$mon_objet->query($query);
		*/
		
		
		/*$query = "
		UPDATE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."
		SET
		nb_views=nb_views+1
		WHERE
		uploaded_file_id=".$_GET["uploaded_file_id"]."
		;";

		$query_result = $mon_objet->query($query);
		*/
	}



	//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=1", $_LANG["1"]["titre"]),
	retournerHref("?module_id=5&uploaded_files_section_id=".$r["uploaded_files_section_id"], $r["uploaded_files_section_name"]),
	$r["uploaded_file_title"]
	);

	// titre
	$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


	//$module_content .= "<table  border=\"0\" cellpadding=\"5\" cellspacing=\"5\"><tr><td class=\"tableau\">";
	
$module_content .= "<b>";
	$module_content .= $r["uploaded_file_title"];
$module_content .= "</b>";

$module_content .= "<br />";


		if(isset($_SESSION["sebhtml"]["usr_id"]) AND
		$_SESSION["sebhtml"]["usr_id"] == $r["usr_id"] )
		{
		//$module_content .= "<br />";

		$module_content .= retournerHref("?module_id=15&mode_id=1&uploaded_file_id=$uploaded_file_id", $_LANG["15"]["edit"]);

		}


		if(isset($_SESSION["sebhtml"]["usr_id"]) AND
		is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet) )
		{
		//$module_content .= "<br />";

$module_content .= "<br />";
		
		$module_content .= retournerHref("?module_id=15&mode_id=2&uploaded_file_id=$uploaded_file_id", $_LANG["15"]["rm"]);//remove
	//$module_content .= "<br />";
$module_content .= "<br />";
		$module_content .= retournerHref("?module_id=30&uploaded_file_id=$uploaded_file_id", $_LANG["30"]["titre"]);//deplace


			
		}
		

		$module_content .= "<br />";
	//$module_content .= "</td><td class=\"tableau\">";

	$image = "";
	
	if(is_file($_OPTIONS["usrs_pics"]."/".$r["usr_id"]))
	{
	$image =
"<br /><img src=\"download.php?usrs_pics=".$r["usr_id"]."\" />";

	}
	
	$module_content .= retournerHref("?module_id=4&usr_id=".$r["usr_id"], 
	$r["usr_name"].$image) ;

	//$module_content .= "</td><td class=\"tableau\">";
$module_content .= "<br />";
	$module_content .= $_LANG["6"]["add_time"];

	$module_content .= " : ";
	$gm_timestamp = $r['uploaded_file_add_gmt_timestamp'];

	$module_content .=  format_time_stamp($gm_timestamp, $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);


		if($r['uploaded_file_add_gmt_timestamp'] != $r['uploaded_file_edit_gmt_timestamp'])
		{
		$module_content .= "<br />";
		$module_content .= $_LANG["6"]["modif_time"];
		$module_content .= " : ";

		$gm_timestamp = $r['uploaded_file_edit_gmt_timestamp'];

		$module_content .=  format_time_stamp($gm_timestamp, $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);
		}

$module_content .= "<br />";
	

$module_content .= "<p align=\"justify\">";
	$module_content .= bb2html($r["uploaded_file_description"], "");//formatage en BBcode
$module_content .= "</p>";

	//$module_content .= "</td></tr><tr><td colspan=\"3\" class=\"tableau\">";
$module_content .= "<br />";
		$module_content .= retournerHref("download.php?uploaded_file_id=".$uploaded_file_id, 
		$r["uploaded_file_name"] , "_blank") ;

		//-------------------
		//taille du fichier
		//---------------

		$module_content .= " (";
		$module_content .= filesize($_OPTIONS["uploaded_files_dir"]."/".$uploaded_file_id);
		$module_content .= ")";
$module_content .= "<br />";

//-------------
	//nombre de downloads
	//-------------

	
		$query = "SELECT 
	count(session_id) AS nb_downloads
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["downloads_of_files"]."
	WHERE
	uploaded_file_id=".$_GET["uploaded_file_id"]."
	;";
	
	
	$query_result_2 = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	
	$mon_objet->free_result($query_result_2);
	
	$module_content .= $_LANG["6"]["nb_downloads"];
	
	$module_content .= " : ";
	
	$module_content .= $fetch_result["nb_downloads"];
	
$module_content .= "<br />";

		$module_content .= $_LANG["6"]["md5sum"];
		$module_content .= " : ";
		
		
		$module_content .= md5_file(($_OPTIONS["uploaded_files_dir"]."/".$uploaded_file_id));

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
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_files"]."
WHERE
uploaded_file_id=".$_GET["uploaded_file_id"]."
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
	
		//$Calib_curve_data = array(500=>5, 550=>50,600=>15, 522 => 22);
	
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
	$sql = "
SELECT 

gmt_timestamp

FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["downloads_of_files"]."
WHERE
uploaded_file_id=".$_GET["uploaded_file_id"]."
";
$r = $mon_objet->query($sql);
	
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
$Calib_curve_data = array();

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
	//$bob = array();
	
	//	$Calib_curve_data = array(500=>1,530=>19, 512=>17,600=> 9);
		
	if(count($Calib_curve_data) != 0)//si il y a eu des téléchargements.
	{
	
	//trouve les zéro et les mets à zzéro
	$les_x = array_keys($Calib_curve_data);
	
	$min_x = min($les_x);
	
	$max_x = max($les_x);
	
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


	// sort($Calib_curve_data);
	
	$bob []= $Calib_curve_data;
	}
	
	
/*
$bob = array(
		array(
			2=>5,
			4=>91
			
			),
		array(
			3=>9,
			40=>8
			)
);
*/

$_SESSION["sebhtml"]["calib_curve"] = $bob;

//echo nl2br(print_r($_SESSION["sebhtml"]["calib_curve"], TRUE));//debug

$module_content .= "<br />";
$module_content .= "<br />";
$module_content .= $_LANG["15"]["curve"];

$module_content .= "<br /><img src=\"download.php?calib_curve\" />";

//fin du graphique

//------------------
	//on augment le nb_views
	//------------------
	
}//fin du row_Result == 1

}
?>


