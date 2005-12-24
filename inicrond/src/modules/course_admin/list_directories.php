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

define(__INICROND_INCLUDED__, TRUE);
define(__INICROND_INCLUDE_PATH__, '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

//check if the get is ok to understand.
if (isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'] && is_teacher_of_cours ($_SESSION['usr_id'], $_GET['cours_id']))
{
    $module_title = $_LANG['list_directories'];

    include __INICROND_INCLUDE_PATH__.'modules/courses/includes/functions/inode_full_path.php';

    //get all directories and their locations.
    //to clolumns, the first is the name and the second is the location total length with a link.

    $query = "
    SELECT
    dir_name,
    inode_id_location
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']." AS T1,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']." AS T2
    WHERE
    cours_id=".$_GET['cours_id']."
    AND
    T1.inode_id = T2.inode_id
    ORDER BY dir_name ASC
    ";

    $results = array(array($_LANG['title'], $_LANG['inode_id_location']));

    $rs = $inicrond_db->Execute ($query);

    while ($fetch_result = $rs->FetchRow ())
    {
        $results []= array(
        $fetch_result["dir_name"],
        inode_full_path ($fetch_result['inode_id_location'], $_GET['cours_id']));
    }

    $module_content .= retournerTableauXY ($results);

    $module_content .= "<h3><a href=\"course_admin_menu.php?cours_id=".$_GET['cours_id']."\">".$_LANG['course_admin_menu']."</a></h3>";

}//end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>