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
//the lang file is no included in the pre_modulation script because script such as download.php does not
//require lang variables.

include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";//init inicrond kernel
include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/check_if_each_entry_exists.php";

if(isset($_GET['group_id']) && //list all groups for a course.
$_GET['group_id'] != "" &&
(int) $_GET['group_id'] &&
$cours_id = group_id_to_cours_id($_GET['group_id']) &&
is_teacher_of_cours($_SESSION['usr_id'], $cours_id))//a teacher only can see this very page.
{
    $query = "INSERT INTO
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
    (ev_name, ev_weight, group_id, ev_max)
    VALUES
    ('".$_LANG['new']."', 1, ".$_GET['group_id'].", 25)
    " ;

    $inicrond_db->Execute($query);

    $ev_id = $inicrond_db->Insert_ID();

    $query = "UPDATE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
    SET
    order_id=".$ev_id."
    WHERE
    ev_id=".$ev_id."
    " ;

    $inicrond_db->Execute($query);

    check_if_each_entry_exists($_GET['group_id'], $ev_id);

    include __INICROND_INCLUDE_PATH__.'includes/functions/js_redir.function.php';//javascript redirection
    js_redir("edit_evaluation.php?ev_id=".$ev_id);


}

include '../../includes/kernel/post_modulation.php';
?>