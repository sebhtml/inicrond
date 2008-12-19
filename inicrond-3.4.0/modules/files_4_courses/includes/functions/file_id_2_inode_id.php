<?php
/*
    $Id: file_id_2_inode_id.php 84 2005-12-26 20:31:43Z sebhtml $

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
* @param        integer  $file_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function file_id_2_inode_id($file_id)
{
    global $_OPTIONS;
    global $_RUN_TIME, $inicrond_db;

    $query = "
    SELECT
    inode_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
    WHERE
    file_id=$file_id
    ";

    $rs = $inicrond_db->Execute ($query);

    $fetch_result = $rs->FetchRow();

    return $fetch_result['inode_id'];
}

?>