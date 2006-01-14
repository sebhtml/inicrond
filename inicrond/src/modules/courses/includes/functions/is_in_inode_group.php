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
* @param        integer  $inode_id
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function is_in_inode_group($usr_id, $inode_id)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db;

    if(!isset($usr_id))
    {
        return FALSE;
    }

    if($_SESSION['SUID'])
    {
        return TRUE;
    }

    $query = "
    SELECT
    cours_id,
    inode_id_location
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    inode_id=$inode_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if (is_teacher_of_cours($usr_id, $fetch_result['cours_id']))
    {
        return TRUE;
    }

    //check here if this inode got some parent that are blocked...

    if ($fetch_result['inode_id_location'] != 0)// != 0., not at course root.
    {
        //this is a powerfull recursive call!!
        if (!is_in_inode_group($usr_id, $fetch_result['inode_id_location']))
        {
            return FALSE; //the access is denied for at least one parent.
        }
    }

    //end of checking the parents...

    $query = "
    SELECT
    usr_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
    AND
    usr_id=$usr_id
    AND
    inode_id=$inode_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    return isset($fetch_result['usr_id']) ;
}

?>