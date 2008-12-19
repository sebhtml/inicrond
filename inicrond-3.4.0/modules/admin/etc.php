<?php
/*
    $Id: etc.php 86 2005-12-29 17:53:10Z sebhtml $

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
include __INICROND_INCLUDE_PATH__."modules/user/includes/constants/constants.php";

include "includes/functions/generate_time_drop_list.php";

if($_SESSION['SUID'])
{
    $module_content = "<h2><a href=\"admin_menu.php\">".$_LANG['admin']."</a></h2>";
    $module_title =  $_LANG['options'];

    if(isset($_POST["envoi"]))//formulaire.
    {
        if($_POST['register_validation_mode'] == "")
        {
            $_POST['register_validation_mode'] = MOD_USER_NO_REGISTER_VALIDATION;
            $module_content .= $_LANG['register_validation_mode_not_set'];
        }

        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        foreach($_POST AS $opt_name => $opt_value)
        {
            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_options']."
            SET
            opt_value='$opt_value'
            WHERE
            opt_name='$opt_name'
            ";

            $inicrond_db->Execute($query);
        }

        unlink($_OPTIONS["file_path"]["options_variable"]);//update the files.

        $smarty->assign("message", $_LANG['options_updated']);
    }


    $query =
    "SELECT
    opt_name,
    opt_value
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_options']."
    ";

    $rs = $inicrond_db->Execute($query);
    $options = array();
    $fetch_result = array();

    while($fetch_result2 = $rs->FetchRow())
    {
        $fetch_result[$fetch_result2['opt_name']] = $fetch_result2['opt_value'];
    }

    //input type=text (DEFAULT type...)
    foreach($fetch_result AS  $key => $value)
    {
        $options[$key]="<input type=\"text\" name=\"$key\" value=\"$value\" />";
    }


    //yes-no-select
    $yes_or_no = array(
            'debug_mode',
            'save_page_view',
            'smarty_force_compile',
            'smarty_compile_check',
            'smarty_use_sub_dirs',
            'save_nobody_sessions',
            'html_output_on_one_line'
    );

    include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
    include __INICROND_INCLUDE_PATH__."includes/class/form/Select.class.php";
    include __INICROND_INCLUDE_PATH__."includes/class/form/Option.class.php";

    foreach($yes_or_no AS  $key )
    {
        $select = new Select();
        $select->set_name($key);

        $my_option = new Option();

        if($fetch_result[$key] == 0)
        {
            $my_option->selected();//SELECTED
        }

        $my_option->set_value("0");
        $my_option->set_text($_LANG['no']);
        $select->add_option($my_option);

        $my_option = new Option();

        if($fetch_result[$key] == 1)
        {
            $my_option->selected();//SELECTED
        }

        $my_option->set_value("1");
        $my_option->set_text($_LANG['yes']);
        $select->add_option($my_option);

        $select->validate();

        $options[$key]= $select->get_form_o();
    }

    $options['usr_time_decal'] =   "<select name=\"usr_time_decal\" >";

    foreach ($_OPTIONS["txt_usr_time_decals"] as $value)
    {
        $str = $_LANG["txt_usr_time_decal_$value"];

        if($key == $fetch_result['usr_time_decal'])
        {
            $options['usr_time_decal'] .=  "<OPTION SELECTED VALUE=\"$value\">$str</OPTION>";
        }
        else
        {
            $options['usr_time_decal'] .=  "<OPTION VALUE=\"$value\">$str</OPTION>";
        }
    }

    $options['usr_time_decal'] .=  " </SELECT>";

    $select = new Select();
    $select->set_name('language');

    foreach ($_OPTIONS['languages'] as  $value)
    {
        $my_option = new Option();

        if($value == $fetch_result['language'])
        {
            $my_option->selected();//SELECTED
        }

        $my_option->set_value($value);
        $my_option->set_text($value);
        $select->add_option($my_option);
    }

    $select->validate();
    $options['language'] = $select->get_form_o();

    //theme select list.
    $select = new Select();
    $select->set_name('theme');

    foreach ($_OPTIONS['themes'] as  $value)
    {
        $my_option = new Option();

        if($value == $fetch_result['theme'])
        {
            $my_option->selected();//SELECTED
        }

        $my_option->set_value($value);
        $my_option->set_text($value);
        $select->add_option($my_option);
    }

    $select->validate();
    $options['theme'] = $select->get_form_o();

    $options['footer'] ="<textarea name=\"footer\"  cols=\"50\" rows=\"5\" >".
    ($fetch_result['footer'])."</textarea>";

    $options['header'] ="<textarea name=\"header\" cols=\"50\" rows=\"5\" >".
    ($fetch_result['header'])."</textarea>";

    $selected[MOD_USER_EMAIL_REGISTER_VALIDATION] = '' ;
    $selected[MOD_USER_ADMIN_REGISTER_VALIDATION] = '' ;
    $selected[MOD_USER_NO_REGISTER_VALIDATION] = '' ;

    $selected[$fetch_result['register_validation_mode']] = "SELECTED";

    $options['register_validation_mode']= "<select name=\"register_validation_mode\">

    <option ".$selected[MOD_USER_EMAIL_REGISTER_VALIDATION]." value=\"".MOD_USER_EMAIL_REGISTER_VALIDATION."\">".$_LANG['MOD_USER_EMAIL_REGISTER_VALIDATION']."</option>
    <option ".$selected[MOD_USER_ADMIN_REGISTER_VALIDATION]." value=\"".MOD_USER_ADMIN_REGISTER_VALIDATION."\">".$_LANG['MOD_USER_ADMIN_REGISTER_VALIDATION']."</option>
    <option ".$selected[MOD_USER_NO_REGISTER_VALIDATION]." value=\"".MOD_USER_NO_REGISTER_VALIDATION."\">".$_LANG['MOD_USER_NO_REGISTER_VALIDATION']."</option>

    </select>";

    $options['disconnect_timeout_in_sec'] =  generate_time_drop_list('disconnect_timeout_in_sec', $fetch_result['disconnect_timeout_in_sec'], '0_sec');

    $the_options = array(array($_LANG['opt_name'],$_LANG['opt_value']) );

    foreach($options AS $key => $value)
    {
        $option = $key."<br /><small>" ;

        if (isset ($_LANG[$key]))
        {
            $option .= $_LANG[$key] ;
        }

        $option .= "</small>" ;

        $the_options []= array($option, $value) ;
    }

    $smarty->assign('the_options',  $the_options);

    $module_content .= $smarty->fetch($_OPTIONS['theme']."/admin_etc.tpl");
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>