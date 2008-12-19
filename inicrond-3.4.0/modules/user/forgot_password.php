<?php
/*
    $Id: forgot_password.php 86 2005-12-29 17:53:10Z sebhtml $

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

include __INICROND_INCLUDE_PATH__."includes/functions/inicrond_mail.php";

//-----------------------
// titre
//---------------------
$module_title =  $_LANG['forgot_password'];

if (isset($_GET["new_password_secure_str"]))//to get a new password.
{
    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
    usr_email,
    usr_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['new_password_secure_str']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['new_password_secure_str'].".usr_id
    and
    new_password_secure_str='".$_GET["new_password_secure_str"]."'
    ";

    $rs = $inicrond_db->Execute($query);

    $fetch_result = $rs->FetchRow();

    if(isset($fetch_result['usr_id']))
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";

        $password = substr(hex_gen_32(), 0, 6);//hexadecimal string

        $query = "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        SET
        usr_md5_password='".md5($password)."'
        WHERE
        usr_id=".$fetch_result['usr_id']."
        ";

        $inicrond_db->Execute($query);

        $query = "delete from
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['new_password_secure_str']."
        where
        usr_id = ".$fetch_result['usr_id']."
        " ;

        $inicrond_db->Execute ($query) ;

        inicrond_mail(
        $fetch_result['usr_email'],
        sprintf($_LANG['password_request_on_X_site'], $_OPTIONS['virtual_addr']),
        sprintf($_LANG['there_are_your_new_account_infos'], $fetch_result['usr_name'], $password)
        );

        $module_content .= $_LANG['an_email_as_been_sent'];
    }
    else
    {
        $module_content .= $_LANG['invalid_request'];
    }
}
else //the form...
{
    if(!isset($_POST['usr_name']))
    {
        $module_content .=  "
        <form method=\"POST\">
        ".  $_LANG['usr_name']." : <input type=\"text\" name=\"usr_name\"  />

        <input type=\"submit\"  />
        </form>" ;
    }
    else//analyse des données
    {
        $query = "
        SELECT
        usr_id,
        usr_email
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_name='".$_POST['usr_name']."'
        ";

        $rs = $inicrond_db->Execute($query);

        $fetch_result = $rs->FetchRow();

        $usr_id = $fetch_result['usr_id'] ;
        $usr_email = $fetch_result['usr_email'] ;

        if(!isset($fetch_result['usr_id']))
        {
            $module_content .=  "".$_LANG['UtilisateurExistePas'];
        }
        else//usr valide
        {
            $query = "
            SELECT
            new_password_secure_str
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['new_password_secure_str']."
            WHERE
            usr_id = $usr_id
            ";

            $rs = $inicrond_db->Execute($query);

            $fetch_result = $rs->FetchRow();

            if(isset($fetch_result["new_password_secure_str"]))//already asked a password...
            {
                $module_content .= $_LANG['a_request_is_already_sent'];
            }
            else
            {
                include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";

                $secure_string = hex_gen_32();//hexadecimal string

                inicrond_mail(
                $usr_email,
                sprintf($_LANG['password_request_on_X_site'], $_OPTIONS['virtual_addr']),
                $_LANG['click_here_to_get_your_password']."<br /><a href=\"".$_OPTIONS['virtual_addr']."modules/user/forgot_password.php?new_password_secure_str=$secure_string\">".$_OPTIONS['virtual_addr']."modules/user/forgot_password.php?new_password_secure_str=$secure_string</a>"
                );


                $query = "
                insert into
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['new_password_secure_str']."
                (usr_id, new_password_secure_str)
                values
                ($usr_id, '$secure_string')

                " ;

                $inicrond_db->Execute($query);

                $module_content .= "".$_LANG['a_confirmation_mail_has_been_sent'];
            }
        }
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>