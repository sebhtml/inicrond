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
* return the list
*
* @param        integer  $cours_id    id of a course
* @param        integer  $inode_id_location   default selection
* @param        integer  $inode_id   an inode id not to include...
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function drop_down_list_dirs($cours_id, $inode_id_location, $inode_id = -1)
{
    global $_OPTIONS, $_RUN_TIME, $inicrond_db, $_LANG;

    $select = new Select();
    $select->set_name('inode_id_location');
    $select->set_text($_LANG['inode_id_location']);

    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']."
    WHERE
    cours_id=$cours_id
    and
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
    ";

    $rs = $inicrond_db->Execute($query);

    while($fetch_result = $rs->FetchRow())
    {
        $my_option = new Option();

        if($fetch_result['inode_id'] == $inode_id_location)
        {
            $my_option->selected();//SELECTED
        }

        $my_option->set_value($fetch_result['inode_id']);

        $my_option->set_text(strip_tags(inode_full_path($fetch_result['inode_id'])));


        //the one you want to check if the other is in this one//the one to check
        if(!is_in_dir_relation($inode_id, $fetch_result['inode_id']))
        {
            $select->add_option($my_option);
        }
    }

    //add the course level (level 0)

    $my_option = new Option();

    if($inode_id_location == 0)
    {
        $my_option->selected();//SELECTED
    }

    $my_option->set_value('0');

    $query = "
    SELECT
    cours_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
    WHERE
    cours_id=$cours_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $my_option->set_text($fetch_result['cours_name']);
    $select->add_option($my_option);

    $select->validate();

    return $select;
}

?>