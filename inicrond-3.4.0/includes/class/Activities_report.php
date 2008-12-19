<?php
/*
    $Id: Activities_report.php 113 2006-01-18 01:40:20Z sebhtml $

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

/*
Changes :

december 15, 2005
        I formated the code correctly.

                --sebhtml

*/

class
Activities_report
{
    var $inicrond_db;
    var $init_report_selection_msg_str;
    var $the_question_str;
    var $actions_table_name;
    var $elements_table_name;
    var $field_id_name;
    var $_LANG;
    var $field_name_name;
    var $script_name;
    var $report_presentation_msg_str;
    var $_RUN_TIME;
    var $cours_id;
    var $_OPTIONS;
    var $module_name;
    var $detail_php_script_path;
    var $extra_where_clause_for_check;

    function Execute ()
    {
        $module_content = "";

        if(isset($_GET[$this->field_id_name]) && $_GET[$this->field_id_name] != ""
        && (int) $_GET[$this->field_id_name] && is_in_charge_in_course($_SESSION['usr_id'], $this->cours_id))
        {
            $inicrond_db = $this->inicrond_db;
            $_OPTIONS = $this->_OPTIONS;
            $_LANG = $this->_LANG;

            $query = "
            SELECT
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id,
            ".$this->field_name_name."
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$this->elements_table_name].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id =
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$this->elements_table_name].".inode_id
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id
            and
            ".$this->field_id_name."=".$_GET[$this->field_id_name]."
            ";

            $query_result = $inicrond_db->Execute($query);

            $fetch_result = $query_result->FetchRow();
            $cours_infos = get_cours_infos($fetch_result['cours_id']);

            $module_content .= retournertableauXY($cours_infos);

            $module_content .= $_LANG[$this->field_name_name]." : ".$fetch_result[$this->field_name_name];

            if(!(isset($_GET['group_id']) &&
            $_GET['group_id'] != "" &&
            (int) $_GET['group_id']
            ))//show the actual report...
            {//select a group dude.
                $module_content .= "<br />".$_LANG[$this->init_report_selection_msg_str]."<br />";

                //$rs = $inicrond_db->Execute($query);
                $query = "SELECT
                group_id,
                group_name,
                default_pending
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
                WHERE
                cours_id=".$this->cours_id."
                ";

                $query_result = $inicrond_db->Execute($query);

                while($fetch_result = $query_result->FetchRow())
                {
                    $module_content .= retournerHref(
                    "".$this->script_name."?group_id=".$fetch_result['group_id']."&".$this->field_id_name."=".$_GET[$this->field_id_name],
                    $fetch_result['group_name']
                    )."<br />";
                }
            }
            else
            {
                /* Here I get all the user from this group and I say OK if he/she downloaded it or I say no*/
                $query = "
                SELECT
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_name,
                usr_prenom,
                usr_nom
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                WHERE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
                AND
                group_id=".$_GET['group_id']."
                ORDER BY usr_nom ASC
                ";

                $query_result = $inicrond_db->Execute($query);
                $tableau = array(array($_LANG['usr_nom'], $_LANG['usr_prenom'],$_LANG['usr_name'], $_LANG[$this->the_question_str], $_LANG['actions_amount'], $_LANG['details']));

                while($fetch_result =$query_result->FetchRow())
                {
                    $query = "SELECT
                    count(usr_id) AS actions_amount
                    FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$this->actions_table_name].",
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
                    WHERE
                    usr_id=".$fetch_result['usr_id']."
                    AND
                    ".$this->field_id_name."=".$_GET[$this->field_id_name]."
                    and
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$this->actions_table_name].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
                    ";

                    if($this->extra_where_clause_for_check !=  "")
                    {
                            $query.=" AND
                            ".$this->extra_where_clause_for_check."
                            ";
                    }


                    $query_result2 = $inicrond_db->Execute($query);
                    $fetch_result2 = $query_result2->FetchRow();

                    $answer = $fetch_result2['actions_amount'] ? $_LANG['yes'] : "<b><span style=\"color: red;\">".$_LANG['no']."</span></b>";

                    $tableau []= array($fetch_result['usr_nom'], $fetch_result['usr_prenom'],  retournerHref(
                    __INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result['usr_id'],
                    $fetch_result['usr_name']
                    ), $answer,
                    $fetch_result2['actions_amount'],
                    "<a href=\"".$this->detail_php_script_path."?&usr_id=".$fetch_result['usr_id']."&".$this->field_id_name."=".$_GET[$this->field_id_name]."&join\">".$_LANG['details']."</a>");
                }

                $query = "SELECT
                group_name
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
                WHERE
                group_id=".$_GET['group_id']."
                ";

                $query_result = $inicrond_db->Execute($query);
                $fetch_result = $query_result->FetchRow();

                $module_content .= "<br />".$_LANG['a_group']." : ".retournerHref(__INICROND_INCLUDE_PATH__."modules/groups/grp.php?group_id=".$_GET['group_id'], $fetch_result['group_name'])."<br />";

                $query = "SELECT
                ".$this->field_name_name."
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$this->elements_table_name]."
                WHERE
                ".$this->field_id_name."=".$_GET[$this->field_id_name]."
                ";

                $query_result = $inicrond_db->Execute($query);
                $fetch_result = $query_result->FetchRow();

                $module_content .= $_LANG[$this->report_presentation_msg_str]."<br /><br />";

                $module_content .= retournerTableauXY($tableau);
            }

            return $module_content;
        }//end of the method Execute.
    }//security check.
}//end of the class.

?>