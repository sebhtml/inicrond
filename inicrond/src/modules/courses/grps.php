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

define ('__INICROND_INCLUDED__', TRUE);
define ('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if (isset ($_SESSION['usr_id']) && isset ($_GET['cours_id']) && (int) $_GET['cours_id'] && is_teacher_of_cours ($_SESSION['usr_id'], $_GET['cours_id']))
{
    $module_title = $_LANG['change_grps_for_course'];

    include __INICROND_INCLUDE_PATH__."includes/class/Group_property_checkbox.php";

    $Group_property_checkbox = new Group_property_checkbox;
    $Group_property_checkbox->inicrond_db = &$inicrond_db;
    $Group_property_checkbox->_OPTIONS = &$_OPTIONS;
    $Group_property_checkbox->_LANG = &$_LANG;
    $Group_property_checkbox->cours_id = $_GET['cours_id'];
    $Group_property_checkbox->elm_field_name = "is_student_group";
    $module_content .=  $Group_property_checkbox->Execute ();
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>