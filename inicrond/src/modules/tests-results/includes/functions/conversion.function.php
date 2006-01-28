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
* transform a result in a course id
*
* @param        integer  $result_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function result_2_usr($result_id)
{
    global $_OPTIONS;
    global $_RUN_TIME, $inicrond_db;

    if(!isset($result_id))
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
    result_id=$result_id
    ";

    $rs = $inicrond_db->Execute($query);

    $fetch_result = $rs->FetchRow();

    return $fetch_result['usr_id'];
}

/**
* transform a result in a course id
*
* @param        integer  $result_id    id of the result
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function result_2_cours($result_id)
{
    if(!isset($result_id))
    {
        return FALSE;
    }

    global $_OPTIONS;
    global $_RUN_TIME, $inicrond_db;


    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id
    and
    result_id=$result_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id
    ";

    $rs = $inicrond_db->Execute($query);

    $fetch_result = $rs->FetchRow();

    return $fetch_result['cours_id'];
}

?>
