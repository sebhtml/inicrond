<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : view 
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
include "modules/forum/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

	//-----------
		//discussion courante..
		//------------
		
		
			
		$query = "SELECT
		forum_discussion_id
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
		WHERE
		forum_sujet_id=".$_GET["forum_sujet_id"]."
		;";
		
		$query_result = $mon_objet->query($query);
				
		$fetch_result = $mon_objet->fetch_assoc($query_result);
		
		
		$forum_discussion_id = $fetch_result["forum_discussion_id"] ;//pour tantot..
		
if(isset($_GET["forum_sujet_id"]) AND
$_GET["forum_sujet_id"] != "" AND
(int) $_GET["forum_sujet_id"] AND
isset($_GET["mode_id"]) AND//mode demandÃ©
$_GET["mode_id"] == 0 
) //changer de sectio
//changer de forum...
{
	
include "modules/forum/includes/move_a_thread.php";
}
elseif(isset($_GET["forum_sujet_id"]) AND
$_GET["forum_sujet_id"] != "" AND
(int) $_GET["forum_sujet_id"] AND
isset($_GET["mode_id"]) AND//mode demandÃ©
$_GET["mode_id"] == 1  AND
is_mod($_SESSION["sebhtml"]["usr_id"], $forum_discussion_id, $mon_objet)
) //bloquer/dÃ©bloquer un thread
//
{

		
	$query = "SELECT
	locked
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
	WHERE
	forum_sujet_id=".$_GET["forum_sujet_id"]."
	;";
	
	$query_result = $mon_objet->query($query);
			
	$fetch_result = $mon_objet->fetch_assoc($query_result);
	
	$mon_objet->free_result($query_result);
	
	
	if($fetch_result["locked"] == 0)
	{
$sql = "
		UPDATE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
		SET
		locked=1
		WHERE
		forum_sujet_id=".$_GET["forum_sujet_id"]."
		AND
		locked=0
		;";

		//$query_result = $mon_objet->query($sql);
		
		//if($mon_objet->num_rows($query_result) == 0)
	}
	else
	{
$sql = "
		UPDATE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
		SET
		locked=0
		WHERE
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].".forum_sujet_id=".$_GET["forum_sujet_id"]."
		AND
		locked=1
		;";

		
	}
	
	$query_result = $mon_objet->query($sql);
}

if(isset($_GET["forum_sujet_id"]) AND
$_GET["forum_sujet_id"] != "" AND
(int) $_GET["forum_sujet_id"]
)
{
	
	//------------------
	//on augment le nb_views
	//------------------
	
	if(!preg_match($_OPTIONS["preg_agent"], $_SERVER["HTTP_USER_AGENT"]))
	{
	
		/*
		
CREATE TABLE views_of_threads  (

session_id BIGINT UNSIGNED,
KEY session_id (session_id),

forum_sujet_id BIGINT UNSIGNED,
KEY forum_sujet_id (forum_sujet_id),

gmt_timestamp BIGINT UNSIGNED 

)TYPE=MyISAM;

*/	
		$query = "
		INSERT
		INTO
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_threads"]."
		(session_id, forum_sujet_id, gmt_timestamp)
		VALUES
		(".$_SESSION["sebhtml"]["session_id"].", ".$_GET["forum_sujet_id"].", ".gmmktime().")
		";

		$mon_objet->query($query);
	}
	//---------
	//afficher le titre
	//------------------
	
$elements_titre = array();

	$elements_titre []= retournerHref("?module_id=23", $_LANG["23"]["titre"]);//echoLienModule(23);
	
				
	$query = "SELECT forum_discussion_name, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"].".forum_discussion_id
	FROM
	 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
	WHERE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].".forum_sujet_id=".$_GET["forum_sujet_id"]."
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"].".forum_discussion_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"].".forum_discussion_id;";
	
	$query_result = $mon_objet->query($query);
	
	
	$fetch_result = $mon_objet->fetch_assoc($query_result);
	
	$mon_objet->free_result($query_result);
	
	

	$elements_titre []= retournerHref("?module_id=24&forum_discussion_id=".$fetch_result["forum_discussion_id"],
	 $fetch_result["forum_discussion_name"]);
	
	
	

		$queries["SELECT"] ++; // comptage
	$query = "SELECT forum_message_titre
	FROM
	 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
	WHERE
	forum_sujet_id=".$_GET["forum_sujet_id"]."
	;";
	
	if(!$query_result = $mon_objet->query($query))
	{
	die($query." ".$mon_objet->error());
	}
	
	$fetch_result = $mon_objet->fetch_assoc($query_result);
	
	$mon_objet->free_result($query_result);
	
	$elements_titre []= $fetch_result["forum_message_titre"];
	

	
//-----------------------
// titre
//---------------------
$module_title = retourner_titre(
$elements_titre,
$_OPTIONS["separator"], $_OPTIONS["titre"]);



	if(isset($_SESSION["sebhtml"]["usr_id"]) AND
	peut_il_replier($_SESSION["sebhtml"]["usr_id"], $_GET["forum_sujet_id"], $mon_objet))//peut-il replier ?
	{
	$module_content .= retournerHref("?module_id=26&forum_sujet_id=".$_GET["forum_sujet_id"], 
	$_LANG["26"]["titre"]);//replier

	}
	
		
	if(isset($_SESSION["sebhtml"]["usr_id"]) AND
	is_mod($_SESSION["sebhtml"]["usr_id"], $forum_discussion_id, $mon_objet //en haut.
	)
	)//moderateur seulement
	{
	$module_content .= " (";
	$module_content .= retournerHref("?module_id=25&mode_id=0&forum_sujet_id=".$_GET["forum_sujet_id"],
	 $_LANG["25"]["changer_de_discussion"]);//
	  $module_content .= $_OPTIONS["separator"];
	  
	 $module_content .= retournerHref("?module_id=25&mode_id=1&forum_sujet_id=".$_GET["forum_sujet_id"],
	 $_LANG["25"]["close_open"]);//lock-unlock
	 
	 
	$module_content .= ")";
	}
	
		
	//--------------------
	//affiche la liste des massage dune belle maniï¿½e
	//---------------------
	
	//$queries["SELECT"] ++; // comptage
	$query = "SELECT 
	forum_message_id,
	forum_message_titre, forum_message_contenu, forum_message_id,
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_name,  ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_signature, usr_status,
	forum_message_add_gmt_timestamp, forum_message_edit_gmt_timestamp
	FROM
	 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	forum_sujet_id=".$_GET["forum_sujet_id"]."
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"].".usr_id
	;";
	
	//include "includes/fonctions/BBcode_inc.php";//fonctions BOBUcode
	
	$query_result = $mon_objet->query($query);
	

	$tableau = array(
	);
	
	while($fetch_result = $mon_objet->fetch_assoc($query_result))
	{
	$ligne = "";

	$ligne .= "<a name=".$fetch_result["forum_message_id"]."></a>";//ancre.
	
$ligne .=  "<b>".$fetch_result["forum_message_titre"]."</b>";
if(isset($_SESSION["sebhtml"]["usr_id"]) AND 
		$_SESSION["sebhtml"]["usr_id"] == $fetch_result["usr_id"] )//Ã©diter
		{
		$ligne .=  " (";
		$ligne .= retournerHref("?module_id=26&forum_message_id=".
		$fetch_result["forum_message_id"], $_LANG["common"]["edit"]);
		$ligne .=  ")";
		}
	$ligne .=  "<br />";
	
	$image = "";
	
	if(is_file($_OPTIONS["usrs_pics"]."/".$fetch_result["usr_id"]))
	{
	$image =
"<br /><img src=\"download.php?usrs_pics=".$fetch_result["usr_id"]."\" />";

	}

$ligne .=  retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"], 
$fetch_result["usr_name"].$image);

	
		$ligne .=  "<br />";

$ligne .= bb2html($fetch_result["usr_status"], "");

	
	$ligne .=  "<br />";



	
	//---------------
	//informations temporels
	//---------------

	
	$ligne .=  $_LANG["common"]["add_date"];
	$ligne .=  " : ";
	$ligne .=  format_time_stamp($fetch_result["forum_message_add_gmt_timestamp"],
	 $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);
	
		if($fetch_result["forum_message_add_gmt_timestamp"] != 
		$fetch_result["forum_message_edit_gmt_timestamp"])
		{
		$ligne .=  "<br />";
		$ligne .=  $_LANG["6"]["modif_time"];
		$ligne .=  " : ";
		$ligne .=  format_time_stamp($fetch_result["forum_message_edit_gmt_timestamp"],
		$_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);
		}
	
		
	

	
	$ligne .=  "<p align=\"justify\">";
	$ligne .=  bb2html($fetch_result["forum_message_contenu"], "");
	$ligne .=  "</p>";


		
$ligne .=   bb2html($fetch_result["usr_signature"], "");
	

		


		$tableau[] = array($ligne);
		
	}
	

	
	$mon_objet->free_result($query_result);
	
	//print_r($tableau);
	$module_content .= retournerTableauXY($tableau, "100%");
	
	if(isset($_SESSION["sebhtml"]["usr_id"]) AND
	peut_il_replier($_SESSION["sebhtml"]["usr_id"], $_GET["forum_sujet_id"], $mon_objet))//peut-il replier ?
	{
	$module_content .= retournerHref("?module_id=26&forum_sujet_id=".$_GET["forum_sujet_id"], $_LANG["26"]["titre"]);//replier

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
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["views_of_threads"]."
WHERE
forum_sujet_id=".$_GET["forum_sujet_id"]."
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
$module_content .= $_LANG["28"]["curve"];

$module_content .= "<br /><img src=\"download.php?calib_curve\" />";

//fin du graphique

}
	

?>

