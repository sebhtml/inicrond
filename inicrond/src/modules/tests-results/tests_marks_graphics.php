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

define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.

//conversions
include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/conversion.function.php";

if(is_teacher_of_cours($_SESSION['usr_id'],test_2_cours($_GET['test_id'])))
{
    $module_title = $_LANG['tests_marks_graphics'];

    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/correl_time_vs_score.php?test_id=".$_GET['test_id']."\" /><br /><br />";
    $module_title =  $_LANG['tests-results'];

    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/normal_dist_img.php?test_id=".$_GET['test_id']."\" /><br /><br />";

    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/normal_dist_time_img.php?test_id=".$_GET['test_id']."\" /><br /><br />";

    $module_content .= "<img src=\"".__INICROND_INCLUDE_PATH__."modules/tests-results/attempts_graphic.php?test_id=".$_GET['test_id']."\" /><br /><br />";
}

include __INICROND_INCLUDE_PATH__."includes/kernel/post_modulation.php";

?>