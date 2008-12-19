<?php
/*
    $Id: change_password.php 85 2005-12-27 03:22:23Z sebhtml $

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

if(isset($_GET['usr_id']) && $_GET['usr_id'] != "" && (int) $_GET['usr_id']
&& $_GET['usr_id'] == $_SESSION['usr_id'])
{
    $module_title = $_LANG['change_password'];

    if(!isset($_POST['old_password']))//show the form.
    {
        $module_content .= "<form method=\"POST\">
        ".$_LANG['old_password'].": <input type=\"password\" name=\"old_password\" /><br />
        ".$_LANG['new_password'].": <input type=\"password\" name=\"new_password\" /><br />
        ".$_LANG['new_password_confirm'].": <input type=\"password\" name=\"new_password_confirm\" /><br />
        <input type=\"submit\">
        </form>
        ";
    }
    else//update the database.
    {
        $query = "
        SELECT
        usr_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_id=".$_GET['usr_id']."
        AND
        usr_md5_password='".md5($_POST['old_password'])."'
        LIMIT 1
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        //check if the current is ok.
        if (!isset($fetch_result['usr_id']))
        {
            $module_content .= $_LANG['the_old_password_is_incorrect'];
        }
        //check if the two new password are the same
        elseif ($_POST['new_password'] != $_POST['new_password_confirm'])
        {
            $module_content .= $_LANG['the_two_password_dont_match'];
        }
        //check if the new one is preged correctly.
        elseif (!preg_match($_OPTIONS['preg_usr'],  $_POST['new_password']))
        {
            $module_content .= $_LANG['the_password_is_too_short_or_contains_invalid_characters']."<br /><br />".$_OPTIONS['preg_usr'];
        }
        else//update the database.
        {
            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
            SET
            usr_md5_password='".md5($_POST['new_password'])."'
            WHERE
            usr_md5_password='".md5($_POST['old_password'])."'
            AND
            usr_id=".$_GET['usr_id']."
            LIMIT 1
            ";

            $inicrond_db->Execute($query);
            $module_content .= $_LANG['the_password_have_been_updated'];
        }
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>