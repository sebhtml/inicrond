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
        //membres
        $smarty->assign('CAN_VIEW_USRS',  retournerHref(__INICROND_INCLUDE_PATH__."modules/members/members.php", $_LANG['members']));

        $smarty->assign('CAN_SEE_GRPS',  retournerHref(__INICROND_INCLUDE_PATH__."modules/groups/grps.php", $_LANG['groups']));

        //valider utilisateur
        $smarty->assign('MD_SESS_SEE_ONLINE_PEOPLE_MODULE', retournerHref(__INICROND_INCLUDE_PATH__."modules/seSSi/see_online_people.php", $_LANG['see_online_people']));

        //valider utilisateur
        $smarty->assign('CAN_CHANGE_USRS_ACCESS', retournerHref(__INICROND_INCLUDE_PATH__."modules/admin/access.php", $_LANG['rights']));

        $smarty->assign('MOD_ADMIN_CAN_GIVE_NEW_PASSWORD', retournerHref(__INICROND_INCLUDE_PATH__."modules/admin/give_and_get_a_new_password.php", $_LANG['give_and_get_a_new_password']));

        $smarty->assign('CAN_CHANGE_OPTS', retournerHref(__INICROND_INCLUDE_PATH__."modules/admin/etc.php", $_LANG['options']));

        $smarty->assign('CAN_UPDATE_CONFIG_FILES', retournerHref(__INICROND_INCLUDE_PATH__."modules/admin/update_ro.php", $_LANG['update_read_only_files']));

        $smarty->assign('MD_SESS_CAN_SEE_GRAPH_WITH_HTTP_USER_AGENT',  retournerHref(__INICROND_INCLUDE_PATH__."modules/admin/view_sessions_with_HTTP_USER_AGENT.php", $_LANG['view_sess_with_http_user']));

        $smarty->assign('smarty_cache_config_link',  __INICROND_INCLUDE_PATH__."modules/admin/smarty_cache_config.php");
        $smarty->assign('list_user_in_0_group',  __INICROND_INCLUDE_PATH__."modules/admin/list_user_in_0_group.php");

        $smarty->assign('_LANG',  $_LANG);

        $module_content = $smarty->fetch($_OPTIONS['theme']."/admin_menu.tpl");

        $module_title =  $_LANG['admin'];
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>