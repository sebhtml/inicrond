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

define('__INICROND_INCLUDED__', true);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

$module_title =  $_LANG['connexion'];
$module_content = '' ;

//v?ifie la session
if (isset($_SESSION['usr_id']))
{
    $module_content .= $_LANG['connected'] ;
}
else
{
    //analyse la soumission
    if (isset($_POST["soumission"]))
    {
        $usr_name = $_POST['usr_name'];
        $usr_md5_password = md5($_POST['usr_password']);

        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        $query = "
        SELECT
        usr_id,
        usr_activation,
        usr_time_decal,
        language,
        SUID
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_name='".filter($usr_name)."'
        AND
        usr_md5_password='$usr_md5_password'
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        //trouve le user et vérifie le pass
        if (( isset($fetch_result["usr_activation"]) && $fetch_result["usr_activation"] == '1'))
        {
            $start_gmt_timestamp = inicrond_mktime();
            $end_gmt_timestamp = $start_gmt_timestamp;

            //remove the nobody session.
            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
            SET
            end_gmt_timestamp=".inicrond_mktime().",
            is_online='0'
            WHERE
            session_id='".$_SESSION['session_id'] ."'
            AND
            is_online='1'
            ";

            $inicrond_db->Execute($query);

            //remove his/her old session if he she dont disconnect his/her sessions.

            //update the string for security...
            $query = "
            UPDATE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
            SET
            register_random_validation=NULL,
            new_password_secure_str=NULL
            WHERE
            usr_id=".$fetch_result['usr_id']."
            ";

            $inicrond_db->Execute($query);

            $query = "
            INSERT INTO
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
            (
            usr_id,
            start_gmt_timestamp,
            end_gmt_timestamp,
            REMOTE_ADDR,
            dns,
            HTTP_USER_AGENT
            )
            VALUES
            (
            ".$fetch_result['usr_id'].",
            $start_gmt_timestamp,
            $start_gmt_timestamp,
            '".$_SERVER['REMOTE_ADDR']."',
            '".gethostbyaddr($_SERVER['REMOTE_ADDR'])."',
            '".$_SERVER['HTTP_USER_AGENT']."'
            )
            ";

            $inicrond_db->Execute($query);

            $_SESSION['session_id'] = $inicrond_db->Insert_ID();//session_id.
            $_SESSION['usr_id'] = $fetch_result['usr_id'];
            $_SESSION['start_gmt_timestamp'] = $start_gmt_timestamp;
            $_SESSION['usr_time_decal'] = $fetch_result['usr_time_decal'] ;//pouir le cégep
            $_SESSION['language'] = $fetch_result['language'] ;//
            $_SESSION['SUID'] = $fetch_result['SUID'] ;

            ///////////
            //here I run a maintenance script 25% of a teacher log in
            $random_number = rand (0, 100);

            if($random_number < 25)//25 % of time...
            {
                if(is_teacher_of_at_least_one_course($_SESSION['usr_id']))//most be teacher not to run this too much.
                {

                    /*
                        I would prefer to run this script in a crontab ...
                    */

                    include __INICROND_INCLUDE_PATH__.'includes/kernel/maintenance.php';
                }
            }
            else //do a redirection
            {
                include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

                js_redir($_OPTIONS["log_in_redirection"]);
            }
        }

        elseif (isset($r["usr_activation"]) && $r["usr_activation"] == 0)
        {
            $module_content .= $_LANG['Activation'];
        }
        else
        {
            $module_content .=  $_LANG['AccesDenied'];
        }
    }
    //pas de soumission et pas de session
    else
    {
        $module_content .=  "
        <form method=\"POST\">
        ".  $_LANG['usr_name']." : <input type=\"text\" name=\"usr_name\"  />
        ".  $_LANG['usr_password']." <input type=\"password\" name=\"usr_password\"  />
        <input type=\"submit\" name=\"soumission\"   />
        </form>" ;
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>