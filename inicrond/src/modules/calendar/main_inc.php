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
include "modules/calendar/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(isset($_OPTIONS["INCLUDED"]))//sécurité.
{

	if(isset($_GET["year"]) AND
	$_GET["year"] != "" AND
	(int) $_GET["year"]
	)//année
	{
		if(isset($_GET["month"]) AND
		$_GET["month"] != "" AND
		(int) $_GET["month"]
		)//mois
		{
			if(isset($_GET["day"]) AND
			$_GET["day"] != "" AND
			(int) $_GET["day"]
			)//jour
			{
			
								
			$delta_time = 24*60*60;
					
				
			}
			else//mois courant
			{
		
		//include "includes/class/Month_calendar.class.php";
		
		$calendrier = new Month_calendar($_GET["month"], $_GET["year"], "big", $_LANG["week_days"], $mon_objet);
		
		$tableau = $calendrier->get_calendar();
		
		//version imprimable du calendrier.
$module_content .= retournerHref("printable_CAL.php?year=".$_GET["year"]."&month=". $_GET["month"]."", $_LANG["44"]["print"], "_blank");
$delta_time = $calendrier->days_in_month()*24*60*60;


			}
		}
		else//année courante
		{
		
		$tableau = array();
			foreach($_LANG["months"] AS $key => $month_name)
			{
			$tableau []= array(retournerHref(
			"?module_id=44&year=".$_GET["year"]."&month=$key", $month_name));	
			}
		
	$delta_time = 365*24*60*60;
		

		}

	}
	else//toutes les années...
	{
	
$annees = array(2004, 2005, 2006);
$tableau = array();
			foreach($annees AS $key)
			{
			$tableau []= array(retournerHref(
			"?module_id=44&year=$key", $key));	
			}
			
	

	}
	
	
		
/*
$time_stamp = gmmktime( $_GET["hour"],
$_GET["min"], $_GET["sec"], $_GET["month"], $_GET["day"], $_GET["year"] );//buig ici...


$module_content .= format_time_stamp($time_stamp, $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);

*/
$module_content .= retournerTableauXY($tableau, "", "center");



//------------
//toutes les choses de cette date...
//----------------


	
//$module_content = "";

	$elements_titre = array(retournerHref("?module_id=44",
	$_LANG["44"]["titre"]));
	
	if(isset($_GET["year"]))
	{
	$elements_titre []= retournerHref("?module_id=44&year=".$_GET["year"], $_GET["year"]);
	} 
	
	
	if(isset($_GET["month"]))
	{
	$elements_titre []= retournerHref("?module_id=44&year=".$_GET["year"]."&month=".$_GET["month"], $_LANG["months"][$_GET["month"]]);
	} 
	
	if(isset($_GET["day"]))
	{
	 $elements_titre []= retournerHref("?module_id=44&year=".$_GET["year"]."&month=".$_GET["month"]."&day=". $_GET["day"], $_GET["day"]);
	} 
	
	if(isset($_GET["hour"]))
	{
	$elements_titre []= retournerHref("?module_id=44&year=".$_GET["year"]."&month=".$_GET["month"]."&day=". $_GET["day"]."&hour=".$_GET["hour"], $_GET["hour"]);
	} 
	
	//if(isset($_GET["min"]))
	
	
	
	if(!isset($_GET["month"]))
	{
	$_GET["month"] = 1;
	}
	if(!isset($_GET["day"]))
	{
	$_GET["day"] = 1;
	}
	
	
// titre
$module_title = retourner_titre($elements_titre);

$start = mktime( 0,0, 0, $_GET["month"], $_GET["day"], $_GET["year"] );

//die(date("h:m:s, M:d:Y", $start));
$start -= $_SESSION["sebhtml"]["usr_time_decal"]*60*60 ;

$end = $start + $delta_time ;
			
			$queries[0] =
			"SELECT
				uploaded_file_title AS data2, uploaded_file_id AS data1
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."
	WHERE
	uploaded_file_edit_gmt_timestamp>=$start
	AND
	uploaded_file_edit_gmt_timestamp<$end
	 ";
			
			
			$queries[1] =
			"SELECT
				forum_message_titre AS data3, forum_sujet_id AS data1,
				forum_message_id AS data2
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
	WHERE
	forum_message_edit_gmt_timestamp>=$start
	AND
	forum_message_edit_gmt_timestamp<$end
	
	 ";
						
			
			
			$queries[2] =
			"SELECT
			image_id AS data1,	
image_title AS data2
 
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
	WHERE
	edit_gmt_timestamp>=$start
	AND
	edit_gmt_timestamp<$end
	 ";
			
			
			
			$queries[3] =
			"SELECT
			wiki_id AS data1,
			wiki_title  AS data2
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
	WHERE
	wiki_ts>=$start
	AND
	wiki_ts<$end
	;";
		
			
			
			$queries[4] =
			"SELECT
			usr_id AS data1,
			usr_name  AS data2
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	usr_add_gmt_timestamp>=$start
	AND
	usr_add_gmt_timestamp<$end
	;";
			
			
			

			$queries[5] =
			"SELECT
			link_id AS data1,
			link_title  AS data2
		FROM 
	 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]."
	WHERE
	edit_gmt_timestamp>=$start
	AND
	edit_gmt_timestamp<$end
	;";
			
			
		include "includes/class/Search_layout.class.php";


$mon_bobu = new  Search_layout($queries, $_LANG, $mon_objet, $_OPTIONS);
 $module_content .= $mon_bobu->output();
 	
		     
		
			
			
	
	//
	//le titre :
	//
	
	
}

			
			
		
?>