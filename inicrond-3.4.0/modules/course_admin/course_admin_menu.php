<?php
/*
    $Id: course_admin_menu.php 87 2006-01-01 02:20:14Z sebhtml $

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
include __INICROND_INCLUDE_PATH__.'modules/courses/includes/languages/'.$_SESSION['language'].'/lang.php';

//check if the get is ok to understand.
if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'] && is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id']))
{
    $module_title = $_LANG['course_admin_menu'];

    $links = array(
        'allow_all_inodes',//done
        'disallow_all_inodes',//done

        //for the following, show the name and the location with a hyper link.
        'list_directories',//done
        'list_files',
        'list_tests',
        'list_questions',
        'list_flashes',
        'list_images',
        'list_texts',
        'count_course_elements',

        'list_double_emails',
        'list_double_firstnames',
        'list_double_lastnames'

    );

    foreach($links AS $link)
    {
        $smarty->assign("$link", "<a href=\"".__INICROND_INCLUDE_PATH__."modules/course_admin/$link.php?&cours_id=".$_GET['cours_id']."\">".$_LANG["$link"]."</a>");
    }

    $smarty->assign('_LANG', $_LANG);
    $module_content .= $smarty->fetch($_OPTIONS['theme'].'/course_admin_menu.tpl');

}//end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>