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
	exit();
}
	
if(isset($_SESSION['usr_id']))
{
//$expire_GMT_timestamp = inicrond_mktime() + $_RUN_TIME["auto_disconnect_in_min"]*60;

	$query = "UPDATE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
	SET
	end_gmt_timestamp=".inicrond_mktime()."
	WHERE
	session_id='".$_SESSION['session_id']."'
	AND
	is_online='1'
	";

	$inicrond_db->Execute($query);
}
else//nobody
{

	if (isset ($_SESSION['session_id']))
	{
		//check if the nobody has a session...
		$query = "SELECT
		usr_id	
		FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
		WHERE
		session_id='".$_SESSION['session_id']."'
		AND
		is_online='1'
		
		";
		
		$rs = $inicrond_db->Execute($query);
	
		$r = $rs->FetchRow();
	}	

	if(!isset($r['usr_id']) AND
	$_OPTIONS['save_nobody_sessions']
	)//nobody needs a session
	{
		$start_gmt_timestamp = inicrond_mktime();
		//$expire_GMT_timestamp = inicrond_mktime() + 9999;
		$query = "INSERT INTO
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
		(
		usr_id, 
		start_gmt_timestamp, 
		end_gmt_timestamp,
		REMOTE_ADDR,
		dns,
		HTTP_USER_AGENT,
		is_online
		)
		VALUES
		(
		".$_OPTIONS['usr_id']['nobody'].", 
		$start_gmt_timestamp, 
		$start_gmt_timestamp,
		'".$_SERVER['REMOTE_ADDR']."',
		'".gethostbyaddr($_SERVER['REMOTE_ADDR'])."',
		'".$_SERVER['HTTP_USER_AGENT']."',
		'1'
		)
		";
		$inicrond_db->Execute($query);
	}
	else if (isset ($_SESSION['session_id']))//update nobody's session...
	{
		$query = "UPDATE
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
		SET
		end_gmt_timestamp=".inicrond_mktime()."
		WHERE
		
		session_id='".$_SESSION['session_id']."'
		AND
		is_online='1'
		";

		$inicrond_db->Execute($query);
	}
}

?>
