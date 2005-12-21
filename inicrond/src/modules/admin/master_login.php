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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';



if($_SESSION['SUID'] &&
isset($_GET['usr_id']) &&
$_GET['usr_id'] != "" &&
(int) $_GET['usr_id'])
{
        $query = "UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
        SET
        is_online='0'
        WHERE
        session_id=".$_SESSION['session_id']."
	AND
	is_online='1'
        ";
        
        $inicrond_db->Execute($query);
        
        $query = "SELECT
	usr_id,
	usr_time_decal,
	language,
	SUID
	FROM 
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
	WHERE
	usr_id=".$_GET['usr_id']."
	";
        
	$rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();;
        
        $start_gmt_timestamp = inicrond_mktime();
        
        $query = "INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
        (
        usr_id, 
        start_gmt_timestamp, 
        end_gmt_timestamp,
        REMOTE_ADDR,
        dns,
        HTTP_USER_AGENT
        )
        VALUES
        (
        ".$_GET['usr_id'].", 
        $start_gmt_timestamp, 
        $start_gmt_timestamp,
        '".$_SERVER['REMOTE_ADDR']."',
        '".gethostbyaddr($_SERVER['REMOTE_ADDR'])."',
        '".$_SERVER['HTTP_USER_AGENT']."'
        )
        ";
        
        $inicrond_db->Execute($query);
        
        $_SESSION = NULL ; //destroy the session.
        //session_destroy();
        
        $_SESSION['session_id'] = $inicrond_db->Insert_ID();//session_id.
        $_SESSION['usr_id'] = $_GET['usr_id'];
        $_SESSION['start_gmt_timestamp'] = $start_gmt_timestamp;
        $_SESSION['usr_time_decal'] = $fetch_result['usr_time_decal'] ;//pouir le cégep
        $_SESSION['language'] = $fetch_result['language'] ;//
        $_SESSION['SUID'] = $fetch_result['SUID'] ;
        
        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
        js_redir(__INICROND_INCLUDE_PATH__.$_OPTIONS["redirect_url"]);
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>