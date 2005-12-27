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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';
include "includes/functions/access.php";
include "includes/functions/conversion.inc.php";

if(isset($_GET["forum_discussion_id"]) && $_GET["forum_discussion_id"] != ""
&& (int) $_GET["forum_discussion_id"]
&& can_usr_admin_section($_SESSION['usr_id'], forum_2_section($_GET["forum_discussion_id"])))
{
    /*
    ajoute ou enl?e des groupe pour ce ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
    */

    //-----------------------
    // titre
    //---------------------

    $query = "
    SELECT
    forum_section_name,
    forum_discussion_name,
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']." ,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
    WHERE
    forum_discussion_id=".$_GET["forum_discussion_id"]."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']." .forum_section_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $cours_id = $fetch_result['cours_id'];

    //-----------------------
    // titre
    //---------------------

    $module_title = $_LANG['forums_groups_start'];

    include __INICROND_INCLUDE_PATH__."includes/class/Group_permission_manager.php";//transfer IDs

    $my_groups = new Group_permission_manager;
    $my_groups->inicrond_db = &$inicrond_db;
    $my_groups->_OPTIONS = &$_OPTIONS;
    $my_groups->_LANG= &$_LANG;
    $my_groups->cours_id = $cours_id;
    $my_groups->group_elm_table = 'forums_groups_start';
    $my_groups->elm_field_name = "forum_discussion_id";

    $module_content .= $my_groups->run_this();

    $module_content .= "<h3><a href=\"".__INICROND_INCLUDE_PATH__."modules/mod_forum/main_inc.php?&cours_id=$cours_id\">".$_LANG['mod_forum']."</a></h3>";
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>