<?php
/*
    $Id: grps.php 84 2005-12-26 20:31:43Z sebhtml $

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

if( $_SESSION['SUID'])
{
    $module_content .= "<h2><a href=\"".__INICROND_INCLUDE_PATH__.
    "modules/admin/admin_menu.php\">".$_LANG['admin']."</a></h2>";

    $module_title =  $_LANG['groups'];

    $sql33 = "
    SELECT
    group_id,
    group_name
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
    ";

    $fields = array(
    'group_name' => array(
    "col_title" => $_LANG['a_group'],
    "col_data" => "\$unit = retournerHref(\"".__INICROND_INCLUDE_PATH__."modules/groups/grp.php?group_id=\".\$f[\"group_id\"], \$f[\"group_name\"]);",
    "no_statistics" => TRUE
    )
    );

    include __INICROND_INCLUDE_PATH__."includes/class/Table_columnS.class.php";
    $mon_tableau = new Table_columnS();

    $mon_tableau->sql_base = $sql33;//la requete de base
    $mon_tableau->cols = $fields;//les colonnes
    $mon_tableau->base_url=__INICROND_INCLUDE_PATH__."modules/groups/grps.php?";//l'url de base pour le fichier php.
    $mon_tableau->_LANG=$_LANG;//le language...
    $mon_tableau->inicrond_db=$inicrond_db;
    $mon_tableau->per_page=$_OPTIONS['results_per_page'];

    $module_content .= $mon_tableau->OUTPUT();
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>