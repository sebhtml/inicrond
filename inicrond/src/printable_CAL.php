<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : le main du calendar
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
session_start();//pour la langue.
$_OPTIONS["INCLUDED"] = TRUE;


if(isset($_OPTIONS["INCLUDED"]))//sécurité.
{
include "modules/calendar/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
include "includes/class/Month_calendar.class.php";//la classe calendrier.

include "includes/kernel/db_init.php";

include $_OPTIONS["file_path"]["opt_in_mysql"];//les options comme l'heure...

include "includes/func/titre_inc.function.php";//titre
include "includes/class/Array_printer.class.php";//la classe calendrier.

if($_SESSION["sebhtml"]["usr_communication_language"] == "fr")
	{
	include "includes/lang/fr/index_inc.php";
	}
	elseif($_SESSION["sebhtml"]["usr_communication_language"] == "en")
	{
	include "includes/lang/en/index_inc.php";
	}
	
//include "includes/class/Month_calendar.class.php";
		
		$calendrier = new Month_calendar($_GET["month"], $_GET["year"], "printable", $_LANG["week_days"], $mon_objet);
		
		$tableau = $calendrier->get_calendar();
		
		//version imprimable du calendrier.

	
	//
	//le titre :
	//
	
	$elements_titre = array($_LANG["44"]["titre"]);
	
	
	
	if(isset($_GET["year"]))
	{
	$elements_titre []=  $_GET["year"];
	} 
	
	
	if(isset($_GET["month"]))
	{
	$elements_titre []=  $_LANG["months"][$_GET["month"]];
	} 
	
	
	
	
	
// titre
$module_title = retourner_titre($elements_titre);
	echo "<html>";
echo "<title>".strip_tags($module_title)."</title>";
echo "<body>";
$tableau_X = new Array_printer;
	$tableau_X->SET_array_data($tableau);
	$tableau_X->SET_type("printable");
	
	echo $tableau_X->OUTPUT();	
	echo "</body>";
	echo "</html>";
}

			
			
		
?>