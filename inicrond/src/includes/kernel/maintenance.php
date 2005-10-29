<?php

// $Id$

// <http://inicrond.sourceforge.net/>

//inicrond Copyright (C) 2004-2005  Sebastien Boisvert
/*
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
This script update sessions, X
delete score where begin equal end and score is -10 on 0 or something like that., X
delete tests results delete those with begin equal end. X
delete users pending for one week. X
optimize all tables. X

*/
/*

FILE LOG
friday, october 28, 2005 - sebhtml
    I checked this file for stuff that sould not be there.



*/


$module_content .= $_LANG['maintenance_start'].'<br />';

////////////
//disconnect sessions ..
$now = inicrond_mktime () ; 

//echo 'debug is here!!';

//set the session offline...
$query =        'UPDATE
		'.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].'
		SET
		is_online=\'0\'
		WHERE
		is_online=\'1\'
		AND
		'.$now.' > end_gmt_timestamp + '.$_OPTIONS['disconnect_timeout_in_sec'].'
		';

$inicrond_db->Execute ($query);

$module_content .= $_LANG['maintenance_set_sessions_offline'].'<br />';








/////////////////
//delete score with point max equal 0 and start equal end and old for 1 week. //////////////////////////////////////
  
 $a_week_in_seconds = 60 * 60 * 24 * 7;
 
$query =        'DELETE FROM
		'.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].'
		WHERE
		points_max = 0 
		AND
		time_stamp_end = time_stamp_start
		AND
		'.$now.' >time_stamp_start+'.$a_week_in_seconds.'
		';
		
$inicrond_db->Execute ($query);

$module_content .= $_LANG['delete_old_useless_scores'].'<br />';

/////////////////
//delete test result where begin equal start. old for 1 week.
//////////////////////////////////////
 
$query =   'SELECT
	   result_id
	   FROM
	   '.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].'
	   WHERE
           time_GMT_start = time_GMT_end
           AND
           '.$now.' > time_GMT_start + '.$a_week_in_seconds.'
	   ';
 
$rs = $inicrond_db->Execute($query);


include __INICROND_INCLUDE_PATH__.'modules/tests-results/includes/functions/delete_result_id.php';

while($fetch_result = $rs->FetchRow())
{
    delete_result_id($fetch_result['result_id']);
}
		
$module_content .= $_LANG['delete_old_useless_test_results'].'<br />';

//////////////////
//here all account taht are not activated and old for at least one week are deleted...
 
$query =        'DELETE FROM
		'.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].'
		WHERE
		usr_activation = \'0\'
		AND
		'.$now.' > usr_add_gmt_timestamp + '.$a_week_in_seconds.'
		';
		
$inicrond_db->Execute($query);

$module_content .= $_LANG['maintenance_delete_old_not_activated_accounts'].'<br />';


//final stage : optimize all tables.
 
foreach($_OPTIONS['tables'] AS $table)//for each table
{
 //optimize the table.
    $query = "OPTIMIZE TABLE ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$table]." ";
		
    $inicrond_db->Execute($query);
    $module_content .= $_OPTIONS['table_prefix'].$_OPTIONS['tables'][$table].'<br />' ;

}

$module_content .= $_LANG['maintenance_opt_tab'].'<br />';

 
?>