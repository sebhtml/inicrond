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

/**
*
*
* @param        integer  $usr_id
* @param        integer  $group_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function is_in_charge_of_group($usr_id, $group_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    if( $_SESSION['SUID'])
    {
        return  TRUE;
    }
    if(!isset($usr_id) || !isset($group_id))
    {
        return FALSE;
    }

    $query33 = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    WHERE
    group_id=".$group_id."
    ";

    $query_result33 = $inicrond_db->Execute($query33);
    $fetch_result33 = $query_result33->FetchRow();

    if(is_teacher_of_cours($usr_id,$fetch_result33['cours_id']) )
    {
        return TRUE;
    }

    //first I get the list of course_group_id that the usrr_id is in charge

    $query = "
    SELECT
    usr_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=$usr_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_id=$group_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_in_charge_group_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
    ";


    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return isset($fetch_result['usr_id']);
}

?>