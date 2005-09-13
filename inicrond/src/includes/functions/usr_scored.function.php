<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

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

//
//---------------------------------------------------------------------
*/
if(__INICROND_INCLUDED__)
{
/**
 * to know if a usr got scores
 *
 * @param        integer  $usr_id     usr
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
	function is_scored($usr_id)
	
	{
	global $_OPTIONS;
	global $_RUN_TIME;
	
	$query = "SELECT chapitre_media_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
	WHERE
	usr_id=".$usr_id."
	;";
	
	$r = $inicrond_db->Execute($query);
	$f = $_RUN_TIME["db"]->fetch_assoc($r);

	
	return isset($f['chapitre_media_id']);
	}
/**
 * to know if a media got scores
 *
 * @param        integer  $chapitre_media_id     media
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function is_scored_in_media($chapitre_media_id)
	
	{
	global $_OPTIONS;
	global $_RUN_TIME;
	
	$query = "SELECT chapitre_media_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
	WHERE
	chapitre_media_id=".$chapitre_media_id."
	";
	
	$r = $inicrond_db->Execute($query);
	$f = $_RUN_TIME["db"]->fetch_assoc($r);

	
	return isset($f['chapitre_media_id']);
	}
/**
 * output is a panel with some links for a user
 *
 * @param        integer  $usr_id     usr
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */	
function info_links($usr_id)
{
global $_OPTIONS, $_RUN_TIME, $inicrond_db, $_LANG;



$is_in_charge_of_user=is_in_charge_of_user($_SESSION['usr_id'], $usr_id);

if(
$is_in_charge_of_user

)
{
//check if he/she has a or many sessions.
$query = "SELECT 
count(usr_id)
	FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
	WHERE
	usr_id=".$usr_id."
";
	
	 $rs = $inicrond_db->Execute($query);
  $f = $rs->FetchRow();
  
	if( $f["count(usr_id)"] > 0)
	{
	$output .= " [ "
				. retournerHref("../../modules/seSSi/one.php?usr_id=$usr_id", $f["count(usr_id)"]." ".$_LANG['seSSi']).
				" ] ";
	
	}
	
	/*
	
	time_stamp_start BIGINT UNSIGNED,

time_stamp_end BIGINT UNSIGNED

*/
}

if(
$is_in_charge_of_user
)
{
//check if he/she has a or many flash scores
$query = "SELECT 
count(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".session_id) AS the_count
	FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."

	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".usr_id=".$usr_id."

	AND
time_stamp_start<time_stamp_end	
AND
points_max>0
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".chapitre_media_id
";
	
	 $rs = $inicrond_db->Execute($query);
  $f = $rs->FetchRow();
  
	if( $f["the_count"] > 0)//there is scores
	{
	$output .= " [ "
				. retournerHref("../../modules/marks/main.php?usr_id=$usr_id", $f["the_count"]." ".$_LANG['marks'] )."".
				" ] ";
	
	}
}

/*

time_GMT_start BIGINT UNSIGNED  ,
time_GMT_end BIGINT UNSIGNED  ,

*/
if(
$is_in_charge_of_user
)
{
//check if he/she has a or many tests results
$query = "SELECT 
count(".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id) AS the_count
	FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id=".$usr_id."
	AND
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id
	AND 
	time_GMT_start<time_GMT_end
";
	
	 $rs = $inicrond_db->Execute($query);
  $f = $rs->FetchRow();
  
		
	if($f["the_count"] > 0)
	{
	$output .= " [ "
				. retournerHref("../../modules/tests-results/results.php?usr_id=$usr_id", $f["the_count"]." ".$_LANG['tests-results']).
				" ] ";

	}
}


if(
$is_in_charge_of_user
OR
($usr_id == $_SESSION['usr_id']
AND
can_usr_act_like_that($_SESSION['usr_id'], "CAN_MOD_COURSE_VIEW_DOWNLOADS_FOR_MY_USER")

)
 OR
can_usr_act_like_that($_SESSION['usr_id'], "CAN_MOD_COURSE_VIEW_DOWNLOADS_FOR_USER")
)
{
//check if he/she has a or many tests results
$query = "SELECT 
count(usr_id)
	FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['acts_of_downloading']."
	WHERE
	usr_id=".$usr_id."
	
";
	
	 $rs = $inicrond_db->Execute($query);
  $f = $rs->FetchRow();
  
	
	if($f["count(usr_id)"] > 0)
	{
	$output .= " [ "
				. retournerHref("../../modules/dl_acts_4_courses/show_dl_acts.mo.php?usr_id=$usr_id", $f["count(usr_id)"]." ".$_LANG['dl_acts_4_courses']).
				" ] ";
	
	}
}
return $output;//return the output.


}

//

}

?>