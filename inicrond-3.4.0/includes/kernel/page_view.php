<?php
/*
    $Id: page_view.php 78 2005-12-21 03:16:28Z sebhtml $

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
	exit();
}

if($_OPTIONS['save_page_view'])//save it of not...
{
	$generate_delta_time = microtime();
	$generate_delta_time = explode(" ",$generate_delta_time);
	$generate_delta_time = $generate_delta_time[1].$generate_delta_time[0];
	
	$generate_delta_time = $generate_delta_time-$start_at_This_very_time;
	
	if($generate_delta_time > 5)
	{
	$generate_delta_time = preg_replace('/.+\./', '0.', $generate_delta_time);
	}
	
	$usr_id = isset($_SESSION['usr_id']) ? $_SESSION['usr_id']  :$_OPTIONS['usr_id']['nobody'] ;
		
	$query = 	"INSERT INTO
			".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['page_views']."
			(
			session_id,
			REMOTE_PORT,
			gmt_timestamp,
			requested_url,
			usr_page_title,
			HTTP_KEEP_ALIVE,
			HTTP_CONNECTION,
			generate_delta_time
			)
			VALUES
			(
			".$_SESSION['session_id'].",
			'".$_SERVER['REMOTE_PORT']."',
			".inicrond_mktime().",
			'"."http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."',
			'".addSlashes(strip_tags($module_title))."',
			'".$_SERVER['HTTP_KEEP_ALIVE']."',
			'".$_SERVER["HTTP_CONNECTION"]."',
			$generate_delta_time
			)
			";
			
	$inicrond_db->Execute($query);		
}
	
?>