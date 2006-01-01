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
include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/ev_id_to_cours_id.php";//init inicrond kernel



if(isset($_GET['ev_id']) //list all groups for a course.
&& $_GET['ev_id'] != ""
&& (int) $_GET['ev_id']
&& is_teacher_of_cours($_SESSION['usr_id'], ev_id_to_cours_id($_GET['ev_id'])))//a teacher only can see this very page.
{
    $cours_id = ev_id_to_cours_id($_GET['ev_id']) ;

    include __INICROND_INCLUDE_PATH__.'includes/functions/fonctions_validation.function.php';

    $module_title = $_LANG['edit_evaluation_entries'];

    if(isset($_POST["envoi"]))//data sent : update database and redirect
    {
        /////////////
        foreach($_POST AS $key => $value)//pour chaque donn�ss.
        {
            if(preg_match("/&usr_id=(.+)&ev_score/", $key, $tokens))//les txt pour questions
            {
                $value = str_replace(",", ".", $value);

                (float) $value;

                $query = "UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores']."
                SET
                ev_score=".$value."
                WHERE
                usr_id=".$tokens["1"]."
                AND
                ev_id=".$_GET['ev_id']."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/&usr_id=(.+)&comments/", $key, $tokens))//les txt pour questions
            {
                (float) $value;

                $query = "UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores']."
                SET
                comments='".filter($value)."'
                WHERE
                usr_id=".$tokens["1"]."
                AND
                ev_id=".$_GET['ev_id']."
                ";
                $inicrond_db->Execute($query);
            }
        }
    }

    ////////////
    //show the evaluation informations.

    $query = "SELECT
    ev_name,
    ev_id,
    comments,
    ev_weight,
    ev_max,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations'].".group_id AS group_id,
    group_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id AS cours_id,
    cours_code,
    cours_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." ,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations'].".group_id=  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
    AND
    ev_id=".$_GET['ev_id']."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $ev_max = $fetch_result['ev_max'];

    foreach($fetch_result AS $key => $value)
    {
        $module_content .= "<b>".$_LANG[$key]."</b> : ".nl2br($value)."<br />" ;
    }

    //get the group _id for this evaluation.
    $query = "SELECT
    group_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
    WHERE
    ev_id=".$_GET['ev_id']."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $group_id = $fetch_result['group_id'];

    //select all evaluation entries and make a form to edit it.

    $query = "SELECT
    usr_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id,
    usr_prenom,
    usr_nom,
    ev_score,
    comments
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores']."
    WHERE
    group_id=$group_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
    AND
    ev_id=".$_GET['ev_id']."
    ORDER BY usr_nom ASC
    ";

    $rs = $inicrond_db->Execute($query);

    $module_content .= "<form method=\"POST\">";

    $tableau_to_print = array(array($_LANG['usr_nom'], $_LANG['ev_score'], $_LANG['comments']));

    while($fetch_result = $rs->FetchRow())
    {
            $tableau_to_print []= array( $fetch_result['usr_nom'].", ".$fetch_result['usr_prenom'], "<input type=\"text\" value=\"".$fetch_result['ev_score']."\" name=\"&usr_id=".$fetch_result['usr_id']."&ev_score\" />"."&nbsp;/".$ev_max,
            "<textarea name=\"&usr_id=".$fetch_result['usr_id']."&comments\">".$fetch_result['comments']."</textarea>");
    }

    $module_content .= retournerTableauXY($tableau_to_print);

    $module_content .= "<input type=\"submit\" name=\"envoi\" /> ";

    $module_content .= "</form>";

    include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/ev_id_to_group_id.php";//init inicrond kernel

    $module_content .= "<h4><a href=\"view_evaluations_with_a_group.php?group_id=".ev_id_to_group_id($_GET['ev_id'])."\">".$_LANG['return']."</a></h4>";
}

include '../../includes/kernel/post_modulation.php';

?>