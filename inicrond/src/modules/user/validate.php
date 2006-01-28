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

//email validation

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if (isset($_GET["register_random_validation"]) && $_GET["register_random_validation"] != '')
{
    $module_title =  $_LANG['email_account_validation'];

    $query = "
    SELECT
    usr_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['register_random_validation']."
    WHERE
    register_random_validation='".$_GET["register_random_validation"]."'
    AND
    usr_activation='0'
    and
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['register_random_validation'].".usr_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    if(isset($fetch_result['usr_name']))
    {
        $query = "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['register_random_validation']."
        SET
        usr_activation= '1'
        WHERE
        register_random_validation='".$_GET["register_random_validation"]."'
        AND
        usr_activation = '0'
        ";

        $inicrond_db->Execute($query);

        $query =
        "
        delete from
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['register_random_validation']."
        where
        register_random_validation='".$_GET["register_random_validation"]."'
        " ;

        $inicrond_db->Execute ($query) ;

        $module_content .= sprintf($_LANG['hi_ppl_you_can_connect'], $fetch_result['usr_name']);
    }
    else
    {
        $module_content .= $_LANG['invalid_request'];
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>