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

include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_inode_group.php";//transfer IDs
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/chapitre_media_id_2_inode_id.php";//transfer IDs

if (isset($_SESSION['usr_id']) && //session
isset($_GET['chapitre_media_id']) && //demande quelque chose ??
$_GET['chapitre_media_id'] != "" && //pas de chaine vide
(int) $_GET['chapitre_media_id'] && //changement de type : integer AND
//verify here...
is_in_inode_group($_SESSION['usr_id'], chapitre_media_id_2_inode_id($_GET['chapitre_media_id'])))
{
    if ($_OPTIONS['smarty_cache_config']['course_media']["flash2.tpl"] != 0)// != 0
    {
        $smarty->caching = 1;
        $smarty->cache_lifetime = $_OPTIONS['smarty_cache_config']['course_media']["flash2.tpl"];
    }

    $cache_id = md5($_SESSION['language'].$_GET['chapitre_media_id']) ;

    if (!$smarty->is_cached($_OPTIONS['theme']."/flash2.tpl", $cache_id))
    {
        $query = "
        SELECT
        chapitre_media_width, chapitre_media_height
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
        WHERE
        chapitre_media_id=".$_GET['chapitre_media_id']."
        ";

        $rs = $inicrond_db->Execute($query);

        $fetch_result = $rs->FetchRow();//résultat

        $smarty->assign('chapitre_media_id', $_GET['chapitre_media_id']);
        $smarty->assign('chapitre_media_height', $fetch_result["chapitre_media_height"]);
        $smarty->assign('chapitre_media_width', $fetch_result["chapitre_media_width"]);

        $module_title = "flash2.php?chapitre_media_id=".$_GET['chapitre_media_id'];
    }

    include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";

    $smarty->display($_OPTIONS['theme']."/flash2.tpl", $cache_id);
    $smarty->caching = 0;
}

?>