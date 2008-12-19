<?php
/*
    $Id: remove_evaluation.php 87 2006-01-01 02:20:14Z sebhtml $

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
include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/ev_id_to_cours_id.php";//init inicrond kernel


if(isset($_GET['ev_id'])
&& $_GET['ev_id'] != ""
&& (int) $_GET['ev_id']
&& is_teacher_of_cours($_SESSION['usr_id'], ev_id_to_cours_id($_GET['ev_id'])))//a teacher only can see this very page.
{
    $cours_id = ev_id_to_cours_id($_GET['ev_id']) ;

    $module_title = $_LANG['remove_evaluation'];

    include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/ev_id_to_group_id.php";//init inicrond kernel

    $module_content .= "<h4><a href=\"view_evaluations_with_a_group.php?group_id=".ev_id_to_group_id($_GET['ev_id'])."\">".$_LANG['return']."</a></h4>";

    if(!isset($_GET["ok"]))//not ok yet, show remove link.
    {
        $module_content .= "<a href=\"remove_evaluation.php?ev_id=".$_GET['ev_id']."&ok\">".$_LANG['remove_evaluation']."</a>";
    }
    else//remove it and redirect dude.
    {
        $query = "DELETE
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
        WHERE
        ev_id=".$_GET['ev_id']."
        ";

        $inicrond_db->Execute($query);

        $query = "DELETE
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores']."
        WHERE
        ev_id=".$_GET['ev_id']."
        ";

        $inicrond_db->Execute($query);
    }
}

include '../../includes/kernel/post_modulation.php';

?>