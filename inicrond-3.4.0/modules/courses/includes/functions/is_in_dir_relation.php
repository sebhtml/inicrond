<?php
/*
    $Id: is_in_dir_relation.php 83 2005-12-26 20:28:15Z sebhtml $

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
* return the list
*
* @param        integer  $inode_id_mother   id to check if is the location
* @param        integer  $inode_id_to_check id of the i node.
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function is_in_dir_relation($inode_id_mother, $inode_id_to_check)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    if($inode_id_mother == $inode_id_to_check)//it's the same...
    {
        return TRUE;
    }

    //get the inode_id_location of the inode to check
    $query = "
    SELECT
    inode_id_location
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    inode_id=$inode_id_to_check
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if($fetch_result['inode_id_location'] == 0)
    {
        return FALSE;//it's ok!
    }
    elseif($fetch_result['inode_id_location'] == $inode_id_mother)
    {
        return TRUE;//it is not ok.
    }
    else //recursive call.!!
    {
        return is_in_dir_relation($inode_id_mother, $fetch_result['inode_id_location']);
    }
}

?>