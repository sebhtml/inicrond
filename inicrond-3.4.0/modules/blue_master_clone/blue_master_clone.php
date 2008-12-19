<?php
/*
    $Id: blue_master_clone.php 82 2005-12-24 21:48:25Z sebhtml $

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

define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not
//require lang variables.

if(isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'])//list all groups for a course.
{
    $module_title = $_LANG['blue_master_clone'];
    $module_content = '';
    $course_infos =  get_cours_infos($_GET['cours_id'] );

    $module_content .= retournerTableauXY($course_infos);
    //show the link to my results.

    $module_content .= "<h5><a href=\"view_my_evaluations.php?cours_id=".$_GET['cours_id']."&usr_id=".$_SESSION['usr_id']."\">".$_LANG['view_my_evaluations']."</a></h5>";

    //show the link to list evaluations , tecaher only.

    if(is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id']))//a teacher only can see this very page.
    {

            $module_content .= "<h5><a href=\"list_evaluations.php?cours_id=".$_GET['cours_id']."\">".$_LANG['list_evaluations']."</a></h5>";
    }
}

include '../../includes/kernel/post_modulation.php';
?>