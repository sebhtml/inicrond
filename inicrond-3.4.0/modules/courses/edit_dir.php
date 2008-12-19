<?php
/*
    $Id: edit_dir.php 87 2006-01-01 02:20:14Z sebhtml $

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
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";    //function for access...

if (isset ($_GET['inode_id']) && $_GET['inode_id'] != "" && (int) $_GET['inode_id']
&& is_teacher_of_cours ($_SESSION['usr_id'], inode_to_course ($_GET['inode_id'])))
{
    //get the title of the page.

    //title
    $query = "
    SELECT
    dir_name,
    cours_name,
    T1.cours_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']." AS T2,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']." AS T1
    WHERE
    T1.inode_id=".$_GET['inode_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id= T1.cours_id
    AND
    T1.inode_id = T2.inode_id
    ";

    $rs = $inicrond_db->Execute ($query);
    $fetch_result = $rs->FetchRow ();

    $module_title = $fetch_result["dir_name"];

    /////end of title
    include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/inode_full_path.php";

    $module_content .=  inode_full_path ($_GET['inode_id']);

    if (isset ($_POST["dir_name"]))
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        $query = "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']." AS T1,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']." AS T2
        SET
        dir_name='".filter ($_POST["dir_name"])."'
        WHERE
        T1.inode_id=".$_GET['inode_id']."
        AND
        T1.inode_id = T2.inode_id
        " ;

        $inicrond_db->Execute ($query);
    }

    //show the form.
    //get the inode name
    $query = "
    SELECT
    dir_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']." AS T1,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']." AS T2
    WHERE
    T1.inode_id=".$_GET['inode_id']."
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
    include __INICROND_INCLUDE_PATH__."includes/class/form/Text.class.php";

    $my_text = new Text ();
    $my_text->set_value ($fetch_result["dir_name"]);
    $my_text->set_name ("dir_name");
    $my_text->set_size ("50");
    $my_text->set_text ($_LANG['title']);
    $my_text->validate ();
    $my_form->add_base ($my_text);

    include __INICROND_INCLUDE_PATH__."includes/class/form/Submit.class.php";
    $my_text = new Submit ();
    $my_text->set_value ($_LANG['txtBoutonForms_ok']);
    $my_text->set_name ("okidou");
    $my_text->set_text ($_LANG['txtBoutonForms_ok']);
    $my_text->validate ();
    $my_form->add_base ($my_text);

    $module_content .=  $my_form->output ();
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>