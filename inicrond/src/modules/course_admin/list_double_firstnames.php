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
include __INICROND_INCLUDE_PATH__.'modules/courses/includes/languages/'.$_SESSION['language'].'/lang.php';

//check if the get is ok to understand.
if (isset($_GET['cours_id']) && $_GET['cours_id'] != "" && (int) $_GET['cours_id'] && is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id']))
{
    $module_title = $_LANG['list_double_firstnames'];

    ///////the class to list double stuff.

    include 'includes/class/Not_unique_field_listing.php';
    $Not_unique_field_listing = new Not_unique_field_listing ();
    $Not_unique_field_listing->_OPTIONS = &$_OPTIONS;
    $Not_unique_field_listing->inicrond_db = &$inicrond_db;
    $Not_unique_field_listing->field = 'usr_prenom';
    $Not_unique_field_listing->cours_id = $_GET['cours_id'];
    $module_content .= $Not_unique_field_listing->Render ();

    $module_content .= "<h3><a href=\"course_admin_menu.php?cours_id=".$_GET['cours_id']."\">".$_LANG['course_admin_menu']."</a></h3>";

}//end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>