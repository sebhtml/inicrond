<?php
/*
    $Id: disallow_all_inodes.php 87 2006-01-01 02:20:14Z sebhtml $

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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

//check if the get is ok to understand.
if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'] && is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id']))
{
    $module_title = $_LANG['disallow_all_inodes'];

    if(!isset($_GET["ok"]))
    {
        $module_content .= $_LANG['do_you_want_to_proceed']."<br /><a href=\"?&cours_id=".$_GET['cours_id']."&ok\">".$_LANG['yes']."</a>"
        ."<br /><a href=\"inode.php?&cours_id=".$_GET['cours_id']."\">".$_LANG['no']."</a>";
    }
    else
    {
        $query = "
        SELECT
        group_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        cours_id=".$_GET['cours_id']."
        " ;

        //foreach group, insert an entry for all inodes.
        $rs = $inicrond_db->Execute($query);

        while($fr = $rs->FetchRow())
        {
            $query = "
            DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_groups']."
            WHERE
            group_id=".$fr['group_id']."
            " ;

            //delete all group inodes for this course.
            $inicrond_db->Execute($query);
        }

        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
        js_redir(__INICROND_INCLUDE_PATH__."modules/courses/inode.php?&cours_id=".$_GET['cours_id']."");
    }

    $module_content .= "<h3><a href=\"course_admin_menu.php?cours_id=".$_GET['cours_id']."\">".$_LANG['course_admin_menu']."</a></h3>";

}//end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>