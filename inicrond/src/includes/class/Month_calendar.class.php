<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : classe de connexion database
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

if(isset($_OPTIONS["INCLUDED"]))
{

	class Month_calendar
	{
	
	var $tableau;
	var $year;
	var $month;
		
	
		function Month_calendar($month, $year, $type, $week_days, $mon_objet)
		{
		
		//type small, big, printable
//print_r($mon_objet->stats());//debug
		
		$this->year = $year;
		$this->month = $month;
		
$this->nombre_de_jour = date("t", mktime(0, 0, 0, 1, $month, $year));//nombre de jours.
//cal_days_in_month(CAL_GREGORIAN,  $month, $year);

//$this->contenu .= $nombre_de_jour;//debug

$tableau = array();

if($type == "small")
{
	foreach($week_days AS $key => $day_name)
	{
	$week_days[$key] = "".substr($day_name, 0, 2)."";
	}
}
else//if($type == "big")
{
	foreach($week_days AS $key => $day_name)
	{
	$week_days[$key] = $day_name."";
	}
}

$tableau []= $week_days;

$time_stamp = mktime( 0, 0,0,$month, 1, $year );//buig ici...


$get_date = getdate($time_stamp);

$start_at = $get_date["wday"];

//-----------
//le numéro d'aujourd'hui
//----------

$aujour = date("j", (gmmktime()+$_SESSION["sebhtml"]["usr_time_decal"]*60*60));



$ligne = array();

while($start_at != 0)
{
$ligne []= "&nbsp;";
$start_at--;
}

if(count($ligne) == 7)
{
$tableau []= $ligne;
$ligne = array();
}



for($i = 1;$i < $this->nombre_de_jour+1; $i++)
{
$bold_1 = $bold_2 = "";

if($aujour == $i AND $type == "small")
{
$bold_1 = "<b>";
$bold_2 = "</b>";
}	
	if(0 AND $this->is_there_anything($i, $mon_objet))
	{
	$ligne []= retournerHref(
			"?module_id=44&year=".$year."&month=".$month."&day=$i",
			"<b>".$i."</b>");
	
	}
	else
	{
		if($type == "printable")
		{
	$ligne []= $i;
	//echo $i;
	
		}
		else
		{
		$ligne []= retournerHref(
			"?module_id=44&year=".$year."&month=".$month."&day=$i",
			"$bold_1".$i."$bold_2");
		}
	}
	
	if(count($ligne) == 7)
{
$tableau []= $ligne;
$ligne = array();
}
	
}

if(count($ligne) != 0)
{
	while(count($ligne) != 7)
	{
	$ligne []= "&nbsp;";
	}
$tableau []= $ligne;
}

//print_r($tableau);
		$this->tableau = $tableau;

		}
		
	function get_calendar()
	{
	return $this->tableau;
	
	}
	
	function is_there_anything($day, $mon_objet)
	{
	
	
$start = mktime( 0,
0, 0, $this->month , $day, $this->year );


$end = $start + 24*60*60;

	
	$sql =
			"SELECT
			uploaded_file_id
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."
	WHERE
	uploaded_file_edit_gmt_timestamp>=$start
	AND
	uploaded_file_edit_gmt_timestamp<$end
	 ";
		
	 	
			//die($sql)	;
		
			
			$query_result = $mon_objet->query($sql);
			$num_rows = $mon_objet->num_rows($query_result);
			$mon_objet->free_result($query_result);
			
			if($num_rows != 0)
			{
			return TRUE;			
			}
						
			
					
			$sql =
			"SELECT
				
				forum_message_id
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
	WHERE
	forum_message_edit_gmt_timestamp>=$start
	AND
	forum_message_edit_gmt_timestamp<$end
	
	 ";
						
			$query_result = $mon_objet->query($sql);
			$num_rows = $mon_objet->num_rows($query_result);
			$mon_objet->free_result($query_result);
			
			if($num_rows != 0)
			{
			return TRUE;			
			}
		
			
			$sql =
			"SELECT
			image_id
 
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_images"]."
	WHERE
	edit_gmt_timestamp>=$start
	AND
	edit_gmt_timestamp<$end
	 ";
			
			$query_result = $mon_objet->query($sql);
			$num_rows = $mon_objet->num_rows($query_result);
			$mon_objet->free_result($query_result);
			
			if($num_rows != 0)
			{
			return TRUE;			
			}
			
			$sql =
			"SELECT
			".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."_id
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
	WHERE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."_ts>=$start
	AND
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."_ts<$end
	;";
		
			
			$query_result = $mon_objet->query($sql);
			$num_rows = $mon_objet->num_rows($query_result);
			$mon_objet->free_result($query_result);
			
			if($num_rows != 0)
			{
			return TRUE;			
			}
		
			
			$sql =
			"SELECT
			usr_id
		FROM 
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
	WHERE
	usr_add_gmt_timestamp>=$start
	AND
	usr_add_gmt_timestamp<$end
	;";
			
			$query_result = $mon_objet->query($sql);
			$num_rows = $mon_objet->num_rows($query_result);
			$mon_objet->free_result($query_result);
			
			if($num_rows != 0)
			{
			return TRUE;			
			}
		
			

			$sql =
			"SELECT
			link_id
		FROM 
	 ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["links"]."
	WHERE
	edit_gmt_timestamp>=$start
	AND
	edit_gmt_timestamp<$end
	;";
			
			
			$query_result = $mon_objet->query($sql);
			$num_rows = $mon_objet->num_rows($query_result);
			$mon_objet->free_result($query_result);
			
			if($num_rows != 0)
			{
			return TRUE;			
			}
			
		return FALSE;//rien.
		
	}
		function days_in_month()
		{
		return $this->nombre_de_jour;
		}

	}	
}

?>
