<?php

/*---------------------------------------------------------------------

$Id$

sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

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
-----------------------------------------------------------------------*/

/*
This script update sessions, X
delete score where begin equal end and score is -10 on 0 or something like that., X
delete tests results delete those with begin equal end. X
delete users pending for one week. X
optimize all tables. X

*/

////////////
//disconnect sessions ..
$now = inicrond_mktime() ;

//echo 'debug is here!!';

//set the session offline...
$query = "UPDATE
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
		SET
		is_online='0'
		WHERE
		is_online='1'
		AND
		$now>end_gmt_timestamp+".$_OPTIONS['disconnect_timeout_in_sec']."
		
		";

 $inicrond_db->Execute($query);


 /////////////////
 //delete score with point max equal 0 and start equal end and old for 1 week.
 //////////////////////////////////////
 /*
 ssion_id int(10) unsigned default NULL,
  points_max smallint(5) unsigned default '0',
  points_obtenu smallint(5) unsigned default '0',
  usr_id int(10) unsigned default NULL,
  chapitre_media_id int(10) unsigned default NULL,
  time_stamp_start int(10) unsigned default NULL,
  time_stamp_end int(10) unsigned default NULL,
  secure_str char(32) default NULL,
  PRIMARY KEY  (score_id),
  KEY session_id (session_id),
  KEY usr_id (usr_id),
  KEY chapitre_media_id (chapitre_media_id)
) TYPE=MyISAM;
*/
 //set the session offline...
 
 $a_week_in_seconds = 60*60*24*7;
 
$query = "DELETE FROM
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
		WHERE
		 points_max = 0 
		AND
		time_stamp_end = time_stamp_start
		AND
		$now>time_stamp_start+$a_week_in_seconds
		";
		
 $inicrond_db->Execute($query);
 
  /////////////////
 //delete test result where begin equal start. old for 1 week.
 //////////////////////////////////////
 
/*
sult_id int(10) unsigned NOT NULL auto_increment,
  session_id int(10) unsigned default NULL,
  usr_id int(10) unsigned default NULL,
  time_GMT_start int(10) unsigned default NULL,
  time_GMT_end int(10) unsigned default NULL,
  test_id int(10) unsigned default NULL,
  your_points float default NULL,
  max_points smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (result_id),
  KEY session_id (session_id),
  KEY usr_id (usr_id),
  KEY test_id (test_id)
) TYPE=MyISAM;
*/
 

 
$query = "SELECT
	result_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
	WHERE
time_GMT_start = time_GMT_end
AND
$now>time_GMT_start+$a_week_in_seconds
	";
 
	$rs = $inicrond_db->Execute($query);

include __INICROND_INCLUDE_PATH__.'modules/tests-results/includes/functions/delete_result_id.php';
		while($fetch_result = $rs->FetchRow())
		{
		
		delete_result_id($fetch_result['result_id']);
		}
		
		
//////////////////
//here all account taht are not activated and old for at least one week are deleted...

/*
sr_id int(10) unsigned NOT NULL auto_increment,
  usr_name varchar(16) NOT NULL default '',
  language varchar(8) default 'fr-ca',
  usr_time_decal float default '-5',
  usr_md5_password varchar(32) NOT NULL default '',
  usr_add_gmt_timestamp int(10) unsigned default NULL,
  usr_activation char(1) NOT NULL default '0',
  usr_email varchar(64) default NULL,
  usr_prenom varchar(64) default NULL,
  usr_nom varchar(64) default NULL,
  usr_signature varchar(255) default NULL,
  show_email char(1) NOT NULL default '0',
  SUID char(1) NOT NULL default '0',
  usr_number varchar(16) NOT NULL default '',
  usr_picture_file_name varchar(32) default 'default1',
  register_random_validation varchar(32) default NULL,
  new_password_secure_str varchar(32) default NULL,
  PRIMARY KEY  (usr_id),
  UNIQUE KEY usr_name (usr_name)
) TYPE=MyISAM;

-- -------------------------
*/


 
$query = "DELETE FROM
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
		WHERE
		usr_activation = '0'
		AND
		$now>usr_add_gmt_timestamp+$a_week_in_seconds
		";
		
 $inicrond_db->Execute($query);
 
 
 
 
 
 
 
 
 
 //final stage : optimize all tables.
 
 foreach($_OPTIONS['tables'] AS $table)//for each table
 {
 //optimize the table.
 $query = "OPTIMIZE TABLE ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$table]." ";
		
 $inicrond_db->Execute($query);
 }
 
?>
