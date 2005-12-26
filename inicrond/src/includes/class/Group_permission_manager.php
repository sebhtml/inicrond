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
/*
Changes :

december 15, 2005
        I formated the code correctly.

                --sebhtml

*/

class Group_permission_manager
{
    var $inicrond_db;
    var $_OPTIONS;
    var $_LANG;
    var $cours_id;
    var $group_elm_table;
    var $elm_field_name;

    function run_this()
    {

        $module_content = "";
        $_OPTIONS = $this->_OPTIONS;
        $cours_id = $this->cours_id;
        $inicrond_db = $this->inicrond_db;
        $_LANG = $this->_LANG;

        $course_infos =  get_cours_infos($cours_id);

        $module_content .= retournerTableauXY($course_infos);

        if(isset($_POST["envoi"]))//update the database if there is a submission
        {
            $module_content .= "<h3><span style=\"color: #ff0000 ;\">".$_LANG['the_database_has_been_updated']."</span></h3>";
            //delete all row concerning the inode...
            $query = "DELETE FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$this->group_elm_table]."
            WHERE
            ".$this->elm_field_name."=".$_GET[$this->elm_field_name]."
            ";
            $inicrond_db->Execute($query);

            foreach($_POST AS $key => $value)
            {
                if(preg_match("/group_id=(.+)/", $key, $tokens) )
                //les txt pour questions
                {
                    //check if the group is part of this course...
                    $query = "SELECT
                    group_id
                    FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
                    WHERE
                    group_id=".$tokens["1"]."
                    AND
                    cours_id=$cours_id
                    ";
                    $rs = $inicrond_db->Execute($query);

                    $fetch_result = $rs->FetchRow();

                    if(isset($fetch_result['group_id']))//access granted...
                    {
                        $query = "INSERT INTO
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$this->group_elm_table]."
                        (".$this->elm_field_name.", group_id)
                        VALUES
                        (".$_GET[$this->elm_field_name].", ".$tokens["1"].")
                        ";

                        $inicrond_db->Execute($query);  //insert the inode_group into inode_groups...
                    }
                }
            }
        }

        //show the form.
        //select all groups for this course.
        $query = "SELECT
        group_id ,
        group_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE

        cours_id=$cours_id
        ";
        $rs = $inicrond_db->Execute($query);

        $module_content .= "<h4>".$_LANG['authorized_groups_info']."</h4>";
        $module_content .= "<form method=\"POST\"><table>";
        while($fetch_result = $rs->FetchRow())
        {
                //do I check the box???
                $query = "SELECT
                group_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$this->group_elm_table]."
                WHERE
                ".$this->elm_field_name."=".$_GET[$this->elm_field_name]."
                AND
                group_id=".$fetch_result['group_id']."
                ";
                $rs2 = $inicrond_db->Execute($query);
                $fetch_result2 = $rs2->FetchRow();

                $checked = isset($fetch_result2['group_id']) ? "CHECKED":"" ;

                $module_content .= "<tr><td><input  $checked  type=\"checkbox\"  name=\"group_id=".$fetch_result['group_id']."\" value=\"".$fetch_result['group_id']."\"  /></td><td>".$fetch_result['group_name']."</td></tr>";
        }

        $module_content .= "</table><input type=\"submit\" name=\"envoi\"/></form>";


        return $module_content;
    }
}

?>