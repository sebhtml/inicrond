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

define (__INICROND_INCLUDED__, TRUE);
define (__INICROND_INCLUDE_PATH__, '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if (isset ($_GET['inode_id']) && $_GET['inode_id'] != "" && (int) $_GET['inode_id'])  //check if the get is ok to understand.
{
    //first the inode is converted into a course.
    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    inode_id=".$_GET['inode_id']."
    ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    $cours_id = $fetch_result['cours_id'];

    if (is_teacher_of_cours ($_SESSION['usr_id'], $cours_id))
    {
        if (isset ($_POST['inode_id_location']))
        {
            include __INICROND_INCLUDE_PATH__. "includes/functions/fonctions_validation.function.php";

            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            SET
            inode_id_location=".$_POST['inode_id_location']."
            WHERE
            inode_id=".$_GET['inode_id']."
            " ;

            $inicrond_db->Execute ($query);
        }

        $module_title = $_LANG['inode_location'];
        include "includes/functions/inode_full_path.php";       //transfer IDs

        $module_content .=  inode_full_path ($_GET['inode_id']);

        //show the form.
        //get the inode name
        $query = "
        SELECT
        dir_name,
        inode_id_location
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']." AS T1,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']." AS T2
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id=".$_GET['inode_id']."
        AND
        T1.inode_id = T2.inode_id
        ";

        $rs = $inicrond_db->Execute ($query);
        $fetch_result = $rs->FetchRow ();

        //the form is here!!!

        include __INICROND_INCLUDE_PATH__."includes/class/form/Form.class.php";

        $my_form = new Form ();
        $my_form->set_method ("POST");

        //file_title
        include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
        include __INICROND_INCLUDE_PATH__."includes/class/form/Option.class.php";
        include __INICROND_INCLUDE_PATH__."includes/class/form/Select.class.php";

        //get the cours id and the inode id location
        $query = "
        SELECT
        inode_id_location,
        cours_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        inode_id=".$_GET['inode_id']."
        ";

        $rs = $inicrond_db->Execute ($query);
        $fetch_result22 = $rs->FetchRow ();

        include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/drop_down_list_dirs.php";

        include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_dir_relation.php";

        $my_form->add_base (drop_down_list_dirs($fetch_result22['cours_id'], $fetch_result22['inode_id_location'], $_GET['inode_id']));

        include __INICROND_INCLUDE_PATH__. "includes/class/form/Submit.class.php";

        $my_text = new Submit ();
        $my_text->set_value ($_LANG['txtBoutonForms_ok']);
        $my_text->set_name ("okidou");
        $my_text->set_text ($_LANG['txtBoutonForms_ok']);
        $my_text->validate ();
        $my_form->add_base ($my_text);

        $module_content .=  $my_form->output ();
    }
}                             //end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>
