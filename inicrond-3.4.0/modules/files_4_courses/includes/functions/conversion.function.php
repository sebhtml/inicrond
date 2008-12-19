<?php
/*
    $Id: conversion.function.php 87 2006-01-01 02:20:14Z sebhtml $

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
* to know in which course is a file
*
* @param        integer  $id    the id of a file
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/

function
file_2_cours($file_id)
{
    if(!isset($file_id))
    {
        return FALSE;
    }

    global $_OPTIONS;
    global $_RUN_TIME, $inicrond_db;

    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
    and
    file_id=$file_id
    ";

    $rs = $inicrond_db->Execute($query);

    $fetch_result = $rs->FetchRow();

    return $fetch_result['cours_id'];
}

?>