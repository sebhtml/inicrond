<?php
/*
    $Id: inode_groups.php 87 2006-01-01 02:20:14Z sebhtml $

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

define ('__INICROND_INCLUDED__', TRUE);
define ('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if (isset ($_GET['inode_id']) && $_GET['inode_id'] != "" && (int) $_GET['inode_id'])  //check if the get is ok to understand.
{
    //first the inode is converted into a course.
    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    inode_id=".$_GET['inode_id']."
    ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    $cours_id = $fetch_result['cours_id'];

    if (is_teacher_of_cours ($_SESSION['usr_id'], $cours_id))
    {
        $module_title = $_LANG['authorized_groups'];

        include "includes/functions/inode_full_path.php";       //transfer IDs

        $module_content .=  inode_full_path ($_GET['inode_id']);

        include __INICROND_INCLUDE_PATH__."includes/class/Group_permission_manager.php";        //transfer IDs

        $my_groups = new Group_permission_manager;
        $my_groups->inicrond_db = &$inicrond_db;
        $my_groups->_OPTIONS = &$_OPTIONS;
        $my_groups->_LANG = &$_LANG;
        $my_groups->cours_id = $cours_id;
        $my_groups->group_elm_table = 'inode_groups';
        $my_groups->elm_field_name = 'inode_id';

        $module_content .=  $my_groups->run_this ();
    }
}                             //end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>