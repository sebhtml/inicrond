<?php
/*
    $Id: inherit_from_a_group.php 87 2006-01-01 02:20:14Z sebhtml $

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

include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/group_id_to_cours_id.php';//init inicrond kernel

include __INICROND_INCLUDE_PATH__.'modules/blue_master_clone/includes/functions/check_if_each_entry_exists.php';

if(isset($_GET['group_id']) //list all groups for a course.
&& $_GET['group_id'] != ""
&& (int) $_GET['group_id']
&& is_teacher_of_cours($_SESSION['usr_id'], group_id_to_cours_id($_GET['group_id'])))//a teacher only can see this very page.
{
    $module_title = $_LANG['inherit_from_a_group'];

    $cours_id = group_id_to_cours_id($_GET['group_id']) ;

    ///first check if this group already have evaluations.
    //this module won't work for group that already have evaluations.

    $query = "SELECT
    ev_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
    WHERE
    group_id=".$_GET['group_id']."
    ";
    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if(isset($fetch_result['ev_id']))//ouput an error.
    {
        $module_content .= $_LANG['this_group_already_have_evaluation'];
        //link toreturn to the back page.
        $module_content .= "<h4><a href=\"view_evaluations_with_a_group.php?group_id=".($_GET['group_id'])."\">".$_LANG['return']."</a></h4>";
    }
    else//list the groups that this group can inherit from.
    {
        if(!isset($_POST['group_id']))//show the drop list
        {
            //get the cours_id.
            $query = "SELECT
            cours_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
            WHERE
            group_id=".$_GET['group_id']."
            ";

            $rs = $inicrond_db->Execute($query);
            $fetch_result = $rs->FetchRow();

            //list all groups from the same course except the current group.

            $query = "SELECT
            group_id,
            group_name
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
            WHERE
            cours_id=".$fetch_result['cours_id']."
            AND
            group_id != ".$_GET['group_id']."
            ";

            $rs = $inicrond_db->Execute($query);

            $module_content .= "<form method=\"POST\"><select name=\"group_id\">";

            while($fetch_result = $rs->FetchRow())//foreach group.
            {
                $module_content .= "<option value=\"".$fetch_result['group_id']."\">".
                $fetch_result['group_name']."</option>";
            }//end of while foreach group.

            $module_content .= "</select><input type=\"submit\" /></form>";
        }
        else//inherit the group and redirect to the group evaluations.
        {
                //inherit the compute formula.
                //get the formula algorithm index.

                $query = "SELECT
                final_mark_formula
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
                WHERE
                group_id=".$_POST['group_id']."
                ";

                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();

                //update the formula.

                $query = "UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
                SET
                final_mark_formula = '".$fetch_result['final_mark_formula']."'
                WHERE
                group_id=".$_GET['group_id']."
                ";

                $inicrond_db->Execute($query);

                //get all evaluation from the group that this group will inherit.

                $query = "SELECT
                ev_name,
                comments,
                available,
                ev_final,
                ev_weight,
                ev_max
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
                WHERE
                group_id=".$_POST['group_id']."
                ORDER BY order_id ASC
                ";

                $rs = $inicrond_db->Execute($query);

                while($fetch_result = $rs->FetchRow())
                {
                    $query = "
                    INSERT INTO
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
                    (
                    ev_name,
                    ev_weight,
                    group_id,
                    ev_max,
                    comments,
                    available,
                    ev_final
                    )
                    VALUES
                    (
                    '".$fetch_result['ev_name']."',
                    ".$fetch_result['ev_weight'].",
                    ".$_GET['group_id'].",
                    ".$fetch_result['ev_max'].",
                    '".$fetch_result['comments']."',
                    '".$fetch_result['available']."',
                    '".$fetch_result['ev_final']."'
                    )
                    " ;

                    $inicrond_db->Execute($query);

                    $ev_id = $inicrond_db->Insert_ID();

                    //update the order id flag.

                    $query = "
                    UPDATE
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']."
                    SET
                    order_id=".$ev_id."
                    WHERE
                    ev_id=".$ev_id."
                    " ;

                    $inicrond_db->Execute($query);

                    /*
                        void check_if_each_entry_exists (int group_id, int ev_id)
                        checks if every student of the group <group_id>
                        has a mark for the evaluation <ev_id>
                        if not, the function fill in the database with new data.
                    */

                    check_if_each_entry_exists($_GET['group_id'], $ev_id);
                }//end of while for evaluation for the asked group.     <

                //redirect here.
                include __INICROND_INCLUDE_PATH__.'includes/functions/js_redir.function.php';//javascript redirection

                js_redir('view_evaluations_with_a_group.php?group_id='.($_GET['group_id']));
        }//end of inheritance.
    }//end of group listing.
}//end of security check.

include '../../includes/kernel/post_modulation.php';

?>