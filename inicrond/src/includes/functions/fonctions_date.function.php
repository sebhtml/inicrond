<?php
/*
    $Id$

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005  Sébastien Boisvert

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
/*
Changes :

december 15, 2005
	I formated the code correctly.
	
		--sebhtml

*/
if(!__INICROND_INCLUDED__)
{
	die("hacking attempt!!");
}

/**
 * return a human readable string for a date
 *
 * @param        integer  $gm_timestamp       a timestamp
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
 
function format_time_stamp($gm_timestamp)
{
	global $_OPTIONS, $_LANG, $_RUN_TIME;


	$date = "";
	
	$gm_timestamp = inicrond_convert_time_t_to_user_tz($gm_timestamp);
	
	//$gm_timestamp+=$_OPTIONS["server_time_zone_adjustment_in_seconds"];
	
	$wday = gmdate("w", $gm_timestamp);
	$month_id = gmdate("n", $gm_timestamp) ;
	$year_id = gmdate("Y", $gm_timestamp) ;
	$mday = gmdate("j", $gm_timestamp) ;
	
	$date .= $_LANG["week_day_".$wday];
	//$date .= $tableau["wday"];
	
	$date .= ", ";
	
	if( $_SESSION['language'] == 'fr-ca')//fraqnçais
	{
	
		$date .= $mday;
	
		$date .= " ";
	
		$date .= $_LANG['month_'.$month_id];
		
	}
	else//english by default
	{
		$date .= $_LANG['month_'.$month_id];
		$date .= " ";
		$date .=  $mday;
		$date .= ', ';
	}
		
	$date .= " ";
	$date .=  $year_id;
	$date .= " ";
	
	//debug
	
	$date .=  gmdate("H:i:s", $gm_timestamp) ;//heure:minutesL:secondes
	
	return "".$date." ".$_LANG["txt_usr_time_decal_".$_SESSION['usr_time_decal']]."" ;//output...
}

/**
 * return a human readable string for a time length
 *
 * @param        integer  $time       a number of seconds
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function format_time_length($time)//en secondes
{
	$hours = 0;
	$minutes = 0;

	if (!is_numeric ($time))
	{
		return false ;
	}
	
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