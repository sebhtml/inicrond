<?php
//$Id$

if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}
/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : traiter les timestamps
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
/*
*Fonction qui prend une date au format aaaammjjhhmmss et le formate
*
*/

/*
function format_time_stamp($gm_timestamp, $decalage = 4, $_LANG["txt_usr_time_decals"] = &$_LANG["txt_usr_time_decals"])
{

//ajoute des seconde :
$gm_timestamp += $decalage*60*60;

$date = date("Y-m-d H:i", $gm_timestamp)." (".$_LANG["txt_usr_time_decals"][$decalage].")" ;

return $date ;
}
*/
/*
function format_time_stamp($gm_timestamp, $decalage = "", 
$txt_usr_time_decals = "", $months = "", $week_days = "")
{
global $_OPTIONS;
global $_LANG;
	

$date = "";

$gm_timestamp += $_SESSION["sebhtml"]["usr_time_decal"]*60*60;

$tableau = getdate($gm_timestamp);

$date .= $_LANG["week_days"][$tableau["wday"]];
//$date .= $tableau["wday"];

$date .= ", ";

$date .= $tableau["mday"];

$date .= " ";

$date .= $_LANG["months"][$tableau["mon"]];

$date .= " ";

$date .= $tableau["year"];

$date .= " ";

//ajoute des zéros
$tableau["hours"] = strlen($tableau["hours"]) == 1 ? "0".$tableau["hours"] : $tableau["hours"];
$tableau["minutes"] = strlen($tableau["minutes"]) == 1 ? "0".$tableau["minutes"] : $tableau["minutes"];

$date .= $tableau["hours"].":".$tableau["minutes"];
//$date = date("Y/m/d H:i:s", $gm_timestamp)." (".$txt_usr_time_decals[$decalage].")" ;

return $date ;
}
*/
function format_time_stamp($gm_timestamp, $decalage = "", 
$txt_usr_time_decals = "", $months = "", $week_days = "")
{

global $_OPTIONS;
global $_LANG;
$date = "";

$gm_timestamp += $_SESSION["sebhtml"]["usr_time_decal"]*60*60;

$tableau = getdate($gm_timestamp);

$date .= $_LANG["week_days"][$tableau["wday"]];
//$date .= $tableau["wday"];

$date .= ", ";

	if( $_SESSION["sebhtml"]["usr_communication_language"] == "fr")//fraqnçais
	{

	$date .= retournerHref("?module_id=44&year=".$tableau["year"]."&month=".
	$tableau["mon"]."&day=".$tableau["mday"], $tableau["mday"]);

	$date .= " ";

	$date .= retournerHref("?module_id=44&year=".$tableau["year"]."&month=".
	$tableau["mon"], $_LANG["months"][$tableau["mon"]]);
	
	}
	elseif($_SESSION["sebhtml"]["usr_communication_language"] == "en")//anglais
	{
	
	$date .= retournerHref("?module_id=44&year=".$tableau["year"]."&month=".
	$tableau["mon"], $_LANG["months"][$tableau["mon"]]);
	$date .= " ";
	$date .= retournerHref("?module_id=44&year=".$tableau["year"]."&month=".
	$tableau["mon"]."&day=".$tableau["mday"], $tableau["mday"]);
	$date .= ", ";
	

	}
$date .= " ";

$date .= retournerHref("?module_id=44&year=".$tableau["year"], $tableau["year"]);
	

$date .= " ";

//ajoute des zéros
$tableau["hours"] = strlen($tableau["hours"]) == 1 ? "0".$tableau["hours"] : $tableau["hours"];
$tableau["minutes"] = strlen($tableau["minutes"]) == 1 ? "0".$tableau["minutes"] : $tableau["minutes"];

$tableau["seconds"] = strlen($tableau["seconds"]) == 1 ? "0".$tableau["seconds"] : $tableau["minutes"];

$date .=  $tableau["hours"]
.":".
 $tableau["minutes"]
.":".
 $tableau["seconds"]
	;
	
return "<i>".$date."</i>" ;
}


function format_time_length($time)//en secondes
{
$hours = 0;
$minutes = 0;

	if($time >= 60 * 60)
	{
	$reste_pour_minutes = $time % (60 * 60);
	$hours = ($time - $reste_pour_minutes) / (60 * 60);
	}
	else
	{
	$reste_pour_minutes = $time;
	}
	
	if($reste_pour_minutes >= 60)
	{
	$reste_pour_secondes = $reste_pour_minutes % (60);
	$minutes = ($reste_pour_minutes - $reste_pour_secondes) / (60);
	}
	else
	{
	$reste_pour_secondes = $reste_pour_minutes;
	}
	$hours = (integer) $hours;//pour lécart type et ces choses là, on doit
	//transformer en entier
	$minutes = (integer) $minutes;
	$secondes = (integer) $reste_pour_secondes ;

	



$hours = strlen($hours) == 1 ? "0".$hours : $hours;
$minutes = strlen($minutes) == 1 ? "0".$minutes : $minutes;
$secondes = strlen($secondes) == 1 ? "0".$secondes : $secondes;

return $hours.":".$minutes.":".$secondes;
}
?>
