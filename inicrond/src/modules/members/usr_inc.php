<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : voir profile
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
include "modules/members/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}
//empeche les pas fins
elseif(isset($_GET["usr_id"]) AND
$_GET["usr_id"] != "" AND
(int) $_GET["usr_id"]
)
{

//obtention de l'identificateur
//$usr_id = $_GET["usr_id"] ;

//$queries["SELECT"] ++; // comptage


$query = "SELECT
usr_name,
usr_add_gmt_timestamp,
usr_localisation,
usr_web_site,
usr_job,
usr_hobbies,
usr_email,
usr_status,
usr_signature,
show_email

FROM ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
WHERE usr_id=".$_GET["usr_id"].";";

$query_result = $mon_objet->query($query);
$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);


//$tableau = $tableau[0];

$module_content .= retournerHref("?module_id=500&usr_id=".$_GET["usr_id"], $_LANG["common"]["500"]);


$date = format_time_stamp($fetch_result['usr_add_gmt_timestamp'],
 $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);

$site_web = retournerHref($fetch_result['usr_web_site'], $fetch_result['usr_web_site'], "_blank");


$usr_name = $fetch_result['usr_name']; // pour le titre

$tableau2 = array();

	$image = "";
	
	if(is_file($_OPTIONS["usrs_pics"]."/".$_GET["usr_id"]))
	{
	$image =
"<br /><img src=\"download.php?usrs_pics=".$_GET["usr_id"]."\" />";

	}
$tableau2[]= array($_LANG["4"]["usr_name"], $fetch_result['usr_name'].$image);
$tableau2[]= array($_LANG["4"]["usr_add_gmt_timestamp"], $date);
$tableau2[]= array($_LANG["4"]["usr_localisation"], bb2html($fetch_result['usr_localisation'], ""));
$tableau2[]= array($_LANG["4"]["usr_web_site"], $site_web);
$tableau2[]= array($_LANG["4"]["usr_job"], bb2html($fetch_result['usr_job'], ""));
$tableau2[]= array($_LANG["4"]["usr_hobbies"], bb2html($fetch_result['usr_hobbies'], ""));

if($fetch_result['show_email'] != 0)//montrer le email ???
{
$tableau2[]= array($_LANG["4"]["usr_email"], $fetch_result['usr_email']);
}

$tableau2[]= array($_LANG["4"]["usr_status"], bb2html($fetch_result['usr_status'], ""));
$tableau2[]= array($_LANG["4"]["usr_signature"], bb2html($fetch_result['usr_signature'], ""));


$query = "SELECT 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].".group_id, group_name
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs
WHERE
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs.usr_id=".$_GET["usr_id"]."
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"].".group_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs.group_id
AND
usr_pending=0
;";

$query_result = $mon_objet->query($query);

$string = "";
while($fetch_result = $mon_objet->fetch_assoc($query_result))
{
$string .= retournerHref("?module_id=22&group_id=".$fetch_result["group_id"], $fetch_result["group_name"]);
$string .= "<br />";
}

$mon_objet->free_result($query_result);

$tableau2 []= array($_LANG["21"]["titre"], $string);

$tableau2 []= array($_LANG["35"]["titre"], retournerHref("?module_id=35&what=". 
$usr_name."", $usr_name) );

$elements_titre = array(
retournerHref("?module_id=8",$_LANG["8"]["titre"]),
$usr_name
);

// titre
$module_title = retourner_titre($elements_titre, $_OPTIONS["separator"], $_OPTIONS["titre"]);


$module_content .= retournerTableauXY($tableau2);

}
?>
