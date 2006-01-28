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
/**
 * find if a usr is the leader of a group
 *
 * @param        integer  $usr_id       the ID of the user
 * @param        integer  $group_id      the ID of the group
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function is_chef_of_group($usr_id, $group_id)
{
	global $_OPTIONS, $_RUN_TIME, $inicrond_db;
		
	if(!isset($_SESSION['usr_id']))
	{
		return FALSE;
	}
	
	if($_SESSION['SUID'])
	{
		return TRUE;
	}
	
	if(!isset($group_id))
	{
		echo "group is not set dude";
		return FALSE;
	}

	$query = "
	SELECT 
	cours_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
	WHERE
	group_id=$group_id
	LIMIT 1
	";

 	$rs = $inicrond_db->Execute($query);
  	$fetch_result = $rs->FetchRow();
  
	return is_teacher_of_cours($_SESSION['usr_id'], $fetch_result['cours_id']);
}

/**
 * find if a usr is in a group
 *
 * @param        integer  $usr_id       the ID of the user
 * @param        integer  $group_id      the ID of the group
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function is_usr_in_group($usr_id, $group_id)
{
	global $_OPTIONS, $_RUN_TIME, $inicrond_db;

	if(!isset($_SESSION['usr_id']))
	{
		return FALSE;
	}

	if(!isset($group_id))
	{
		return FALSE;
	}

	$query = "
	SELECT usr_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
	WHERE
	usr_id=$usr_id
	AND
	group_id=$group_id
	LIMIT 1
	";

  	$rs = $inicrond_db->Execute($query);
  	$fetch_result = $rs->FetchRow();
  
	return isset($fetch_result['usr_id']);
}

/**
 * find if a usr is a teacher of a course
 *
 * @param        integer  $usr_id       the ID of the user
 * @param        integer  $cours_id      the ID of the course
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function is_teacher_of_cours($usr_id, $cours_id)
{

	global $_OPTIONS, $_RUN_TIME, $inicrond_db;
	if( $_SESSION['SUID'])
	{
		return  TRUE;
	}

	if(!isset($usr_id))
	{
		return FALSE;
	}	
	
	if(!isset($cours_id) || !$cours_id) //== FALSE
	{
		return FALSE;
	}	

	if(isset($_RUN_TIME["is_teacher_of_cours"]["&usr_id=$usr_id&cours_id=$cours_id&"]))//already asked for this...
	{
		return $_RUN_TIME["is_teacher_of_cours"]["&usr_id=$usr_id&cours_id=$cours_id&"];
	}

	$query = "
	SELECT usr_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
	AND
	usr_id=$usr_id
	AND
	cours_id=$cours_id
	AND
	is_teacher_group = '1'
	LIMIT 1
	";
	
	$rs = $inicrond_db->Execute($query);
  	$fetch_result = $rs->FetchRow();
  
	return isset($fetch_result['usr_id']);
}

/**
 * find if a usr is a teacher of a course
 *
 * @param        integer  $usr_id       the ID of the user
 * @param        integer  $cours_id      the ID of the course
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function is_in_charge_in_course($usr_id, $cours_id)
{

	global $_OPTIONS, $inicrond_db;
	if(!isset($usr_id))
	{
		return FALSE;
	}
		
	if(!isset($cours_id))
	{
		return FALSE;
	}	

	if($_SESSION['SUID'])
	{
		return TRUE;
	}

	//check if member of at least one group that is in charge of another group.
	if(is_teacher_of_cours($usr_id, $cours_id))
	{
		return TRUE;
	}

	$query = "
	SELECT 
	usr_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].",
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
	WHERE
	
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=$usr_id
	AND
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id=$cours_id
	AND
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
	AND
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_in_charge_group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
	AND
	is_student_group = '1'
	LIMIT 1
	";

	//echo $query; exit;

 	$rs = $inicrond_db->Execute($query);
  	$fetch_result = $rs->FetchRow();
  
	return isset($fetch_result['usr_id']);
}

/**
 * find if a usr is a student of a course
 *
 * @param        integer  $usr_id       the ID of the user
 * @param        integer  $cours_id      the ID of the course
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function is_student_of_cours($usr_id, $cours_id)
{
	global $_OPTIONS, $_RUN_TIME, $inicrond_db;
	if( $_SESSION['SUID'])
	{
		return true;
	}	

	if(is_teacher_of_cours($usr_id,  $cours_id))
	{
		return true;
	}
	
	if(!isset($_SESSION['usr_id']))
	{
		return FALSE;
	}

	$query = "
	SELECT usr_id
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
	AND
	usr_id=$usr_id
	AND
	cours_id=$cours_id
	AND
	is_student_group = '1'
	LIMIT 1
	";


  	$rs = $inicrond_db->Execute($query);
  	$fetch_result = $rs->FetchRow();
  
	return isset($fetch_result['usr_id']);
}

/**
 * find if a usr the author of a result
 *
 * @param        integer  $usr_id       the ID of the user
 * @param        integer  $result_id      the ID of the result
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function is_author_of_result($usr_id, $result_id)
{
	global $_OPTIONS, $_RUN_TIME, $inicrond_db;
	if(!isset($_SESSION['usr_id']))
	{
		return FALSE;
	}	

	$query = "
	SELECT 
	usr_id
	
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
	and
	usr_id=".$usr_id."
	AND
	result_id=".$result_id."
	LIMIT 1
	";

 	$rs = $inicrond_db->Execute($query);
  	$fetch_result = $rs->FetchRow();
  
	return (isset($fetch_result["usr_id"]));
}

?>