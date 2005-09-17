<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : view url.
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
xoool - a portail for the web
Copyright (C) 2004  Sebastien Boisvert

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
include "modules/directory/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

if(isset($_GET["link_id"]) AND
$_GET["link_id"] != "" AND
(int) $_GET["link_id"]
)
{
	if(isset($_GET["go"]))
	{
	
$query = "SELECT 
link_url
 FROM
 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]."
 WHERE 
  link_id=". $_GET["link_id"]."
;";

$query_result = $mon_objet->query($query);
$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

		if(!preg_match($_OPTIONS["preg_agent"], $_SERVER["HTTP_USER_AGENT"]))
		{
	

			$query = "
		INSERT
		INTO
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["clicks_for_links"]."
		(session_id, link_id, gmt_timestamp)
		VALUES
		(".$_SESSION["sebhtml"]["session_id"].", ".$_GET["link_id"].", ".gmmktime().")
		";
//die($tmp);
			$mon_objet->query($query);
		
		/*$query = "
			UPDATE
			".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]."
			SET
			nb_hits=nb_hits+1
			WHERE
		link_id=". $_GET["link_id"]."
			;";

			$mon_objet->query($query);
			*/
		}
		
echo js_redir("".$fetch_result["link_url"]."");
exit();
	}

$uploaded_file_id = $_GET["link_id"];

	
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


if(isset($r["link_title"]))
	{
	
	//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=38", $_LANG["38"]["titre"]),
	retournerHref("?module_id=41&directory_section_id=".$r["directory_section_id"], $r["directory_section_name"]),
	$r["link_title"]
	);

	// titre
	$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);

//------------------
	//on augment le nb_views
	//------------------
	if(!preg_match($_OPTIONS["preg_agent"], $_SERVER["HTTP_USER_AGENT"]))
	{
//	$queries["UPDATE"] ++; // comptage
			
			$query = "
		INSERT
		INTO
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_links"]."
		(session_id, link_id, gmt_timestamp)
		VALUES
		(".$_SESSION["sebhtml"]["session_id"].", ".$_GET["link_id"].", ".gmmktime().")
		";
//die($tmp);

		$mon_objet->query($query);
		
		
		
	}
	



	//-----------
	//titre de la page::
	//--------------
	$elements_titre = array(
	retournerHref("?module_id=38", $_LANG["38"]["titre"]),
	retournerHref("?module_id=41&directory_section_id=".$r["directory_section_id"], $r["directory_section_name"]),
	$r["link_title"]
	);

	// titre
	$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


	//$module_content .= "<table  border=\"0\" cellpadding=\"5\" cellspacing=\"5\"><tr><td class=\"tableau\">";
	
$module_content .= "<b>";
	$module_content .= $r["link_title"];
$module_content .= "</b>";

$module_content .= "<br />";


		if(isset($_SESSION["sebhtml"]["usr_id"]) AND
		$_SESSION["sebhtml"]["usr_id"] == $r["usr_id"] )
		{
		//$module_content .= "<br />";
//  link_id=". $_GET["link_id"]."
		$module_content .= retournerHref("?module_id=40&mode_id=1&link_id=". $_GET["link_id"]."", $_LANG["common"]["edit"]);//édition.

		}


		if(isset($_SESSION["sebhtml"]["usr_id"]) AND
		is_usr_in_group($_SESSION["sebhtml"]["usr_id"], 1, $mon_objet) )
		{
		//$module_content .= "<br />";

$module_content .= "<br />";
		
		$module_content .= retournerHref("?module_id=40&mode_id=2&link_id=". $_GET["link_id"]."", $_LANG["common"]["remove"]);//remove
	//$module_content .= "<br />";
	/*
$module_content .= $_OPTIONS["separator"];
		$module_content .= retournerHref("?module_id=30&uploaded_file_id=$uploaded_file_id", $_LANG["30"]["titre"]);//deplace
*/

			
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
	$module_content .= $_LANG["common"]["add_date"];

	$module_content .= " : ";
	//$gm_timestamp = $r['add_gmt_timestamp'];

	$module_content .=  format_time_stamp($r['add_gmt_timestamp'], $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);


		if($r['add_gmt_timestamp'] != $r['edit_gmt_timestamp'])
		{
		$module_content .= "<br />";
		$module_content .= $_LANG["common"]["modif_date"];
		$module_content .= " : ";

		//$gm_timestamp = $r['edit_gmt_timestamp'];

		$module_content .=  format_time_stamp( $r['edit_gmt_timestamp'], $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);
		}

$module_content .= "<br />";
	//$module_content .= "</td></tr><tr><td colspan=\"3\" class=\"tableau\">";

		//include "includes/fonctions/BBcode_inc.php";//fonctions BOBUcode
		//include "includes/fonctions/fonctions_validation_inc.php";//fonction pour valider

//include "includes/fonctions/cbparser.php";//parser BBcode

$module_content .= "<p align=\"justify\">";
	$module_content .= bb2html($r["link_description"], "");//formatage en BBcode
$module_content .= "</p>";

	//$module_content .= "</td></tr><tr><td colspan=\"3\" class=\"tableau\">";
$module_content .= "<br />";

		$module_content .= retournerHref("?module_id=42&link_id=". $_GET["link_id"]."&go" ,$_LANG["42"]["go"],  "_blank")."<br />" ;
/*
			*/
	$module_content .= $_LANG["41"]["nb_hits"];
	
	$module_content .= " : ";
	
	//aller chercher le nombre de visites
	$query = "SELECT 
	count(session_id) AS nb_hits
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["clicks_for_links"]."
	WHERE
	link_id=".$_GET["link_id"]."
	;";
	
	
	$query_result_2 = $mon_objet->query($query);
	
	$fetch_result = $mon_objet->fetch_assoc($query_result_2);
	
	$mon_objet->free_result($query_result_2);
	
	$r["nb_hits"] = $fetch_result["nb_hits"];
	//
	
	$module_content .= $r["nb_hits"];
	/*
$module_content .= "<br />";

		$module_content .= $_LANG["6"]["md5sum"];
		$module_content .= " : ";
		
	//	include "includes/fonctions/files_inc.php";
		
		$module_content .= md5_file(($_OPTIONS["uploaded_files_dir"]."/".$uploaded_file_id));

//	$module_content .= "</td></tr></table>";
*/

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
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_links"]."
WHERE
link_id=".$_GET["link_id"]."
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
	$sql = "
SELECT 

gmt_timestamp

FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["clicks_for_links"]."
WHERE
link_id=".$_GET["link_id"]."
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
$module_content .= $_LANG["42"]["curve"];

$module_content .= "<br /><img src=\"download.php?calib_curve\" />";

//fin du graphique
}//fin du row_Result == 1

}
?>


