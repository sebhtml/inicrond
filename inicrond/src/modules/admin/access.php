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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if($_SESSION['SUID'])
{
        $module_content = "<h2><a href=\"admin_menu.php\">".$_LANG['admin']."</a></h2>";

        /*
        modes :
        0 : activer usr
        1 : deasctivate
        2 : remove
        */

        //activate
        if(isset($_GET['mode_id']) &&
        isset($_GET['usr_id']) &&
        $_GET['mode_id'] == 0 &&
        $_GET['usr_id'] != "")
        {
                $usr_id = $_GET['usr_id'];

                $query = "UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                SET
                usr_activation= '1'
                WHERE usr_id=".$_GET['usr_id']."
                ;";

                if(!$inicrond_db->Execute($query))
                {
                        $module_content .=  $_LANG['UtilisateurExistePas'] ;
                }
        }

        //desactiver
        elseif(isset($_GET['mode_id']) &&
        isset($_GET['usr_id']) &&
        $_GET['mode_id'] == 1 &&
        $_GET['usr_id'] != "" )
        {
                //nodody forever
                if($_OPTIONS['usr_id']['nobody'] != $_GET['usr_id'])//enseignant
                {
                        $query = "UPDATE
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
                        SET
                        usr_activation= '0'
                        WHERE
                        usr_id=".$_GET['usr_id']."
                        ";

                        $inicrond_db->Execute($query);

                        $query = "DELETE
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                        WHERE
                        usr_id=".$_GET['usr_id']."
                        ";//enlève les entrée pour les groupes

                        $inicrond_db->Execute($query);
                }
        }

        //enlever
        else if(isset($_GET['mode_id']) &&
        isset($_GET['usr_id']) &&
        $_GET['mode_id'] == 2 &&
        $_GET['usr_id'] != "" )
        {
                //nobody forever
                if($_OPTIONS['usr_id']['nobody'] != $_GET['usr_id'] )//enseignant
                {
                        //delete question_ordering entries

                        $query = "SELECT
                        result_id
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
                        WHERE
                        usr_id=".$_GET['usr_id']."
                        and
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
                        ";

                        $rs = $inicrond_db->Execute($query);

                        include __INICROND_INCLUDE_PATH__.'modules/tests-results/includes/functions/delete_result_id.php';
                        while($fetch_result = $rs->FetchRow())
                        {
                                delete_result_id($fetch_result['result_id']);
                        }



                        $tables_to_delete_from = array(
                                'acts_of_downloading',
                                'scores',
                                'page_views',
                                'results'
                        );

                        /* Example ::
                        delete from ooo_scores using ooo_online_time, ooo_scores
where ooo_scores.session_id = ooo_online_time.session_id and usr_id =  13
*/
                        foreach($tables_to_delete_from AS $t_name)
                        {
                                $query = "DELETE FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$t_name]."
                                using
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$t_name]."
                                WHERE
                                usr_id=".$_GET['usr_id']."
                                and
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$t_name].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
                                ";

                                $inicrond_db->Execute($query);
                        }

                        $tables_to_delete_from = array(
                        'groups_usrs',
                        'usrs',
                        'views_of_threads',
                        'sebhtml_forum_messages',
                        'online_time',
                        'user_evaluation_scores'
                        );

                        //delete all general table entries.

                        foreach($tables_to_delete_from AS $t_name)
                        {
                                $query = "DELETE FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$t_name]."
                                WHERE
                                usr_id=".$_GET['usr_id']."
                                ";

                                $inicrond_db->Execute($query);
                        }
                }
        }

        //-------------------------------
        // titre de la page:
        //-----------------------

        $module_title =  $_LANG['rights'];

        $query = "SELECT
        usr_name, usr_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_activation= '1'
        AND
        usr_id!=".$_OPTIONS['usr_id']['nobody']."
        AND
        SUID='0'
        ";

        $rs = $inicrond_db->Execute($query);

        while($fetch_result = $rs->FetchRow())
        {
                $module_content .=  $fetch_result['usr_name'];
                $module_content .=  " (";
                $module_content .= retournerHref(__INICROND_INCLUDE_PATH__."modules/admin/access.php?mode_id=1&usr_id=".//désactiver un usr
                $fetch_result['usr_id'], $_LANG['ban']);
                $module_content .=  ")";
                $module_content .=  "<br />";
        }

        $query = "SELECT
        usr_name, usr_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_activation='0'
        AND
        usr_id!=".$_OPTIONS['usr_id']['nobody']."
        AND
        SUID='0'
        ";

        $rs = $inicrond_db->Execute($query);

        while($fetch_result = $rs->FetchRow())
        {
                $module_content .=  $fetch_result['usr_name'];
                $module_content .=  " (";
                $module_content .= retournerHref("../../modules/admin/access.php?mode_id=0&usr_id=".
                $fetch_result['usr_id'], $_LANG['activate']);//activer
                $module_content .=  " | ";
                $module_content .= retournerHref("../../modules/admin/access.php?mode_id=2&usr_id=".
                $fetch_result['usr_id'], $_LANG['delete_usr']);//delete
                $module_content .=  ")";
                $module_content .=  "<br />";
        }

}
include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>