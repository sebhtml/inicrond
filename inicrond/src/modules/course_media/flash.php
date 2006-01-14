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

if (DEBUG)
{
    echo "\$_RUN_TIME[\"usr_id\"]=".$_SESSION['usr_id']."<br />";
    echo "\$_RUN_TIME[\"session_id\"]=".$_SESSION['session_id']."<br />";
}

include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_inode_group.php";
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/chapitre_media_id_2_inode_id.php";//transfer IDs
include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";

if(isset($_SESSION['usr_id']) && //session
isset($_GET['chapitre_media_id']) && //demande quelque chose ??
$_GET['chapitre_media_id'] != "" && //pas de chaine vide
(int) $_GET['chapitre_media_id'] && //changement de type : integer AND
is_in_inode_group($_SESSION['usr_id'], chapitre_media_id_2_inode_id($_GET['chapitre_media_id'])))
{
    $_SESSION['chapitre_media_id'] = $_GET['chapitre_media_id'];

    $inicrond_mktime = inicrond_mktime();
    $HEXA_TAG = hex_gen_32();//hexadecimal string

    $_SESSION["secure_str"] = $HEXA_TAG;//for security reaosns.

    $_SESSION['chapitre_media_id'] = $_GET['chapitre_media_id'] ;//store it for later...
    //die($_SESSION['session_id']);

    $query = "
    INSERT INTO
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
    (
    session_id,
    chapitre_media_id,
    time_stamp_start,
    time_stamp_end,
    secure_str
    )
    VALUES
    (
    ".$_SESSION['session_id'].",
    ".$_GET['chapitre_media_id'].",
    ".$inicrond_mktime.",
    ".$inicrond_mktime.",
    '$HEXA_TAG'
    )
    ";

    $inicrond_db->Execute($query);

    $score_id = $inicrond_db->Insert_ID();//for later
    $_SESSION['score_id'] = $score_id;

    //it yes, put it in a session into mysql...
    if (isset($_GET["question_ordering_id"]) && $_GET["question_ordering_id"] != "" && (int) $_GET["question_ordering_id"])
    {
        $_SESSION["question_ordering_id"] = $_GET["question_ordering_id"];
    }

    $_SESSION['chapitre_media_id'] = $_GET['chapitre_media_id'];

    if ($_OPTIONS['smarty_cache_config']['course_media']["flash.tpl"])// != 0
    {
        $smarty->caching = 1;
        $smarty->cache_lifetime = $_OPTIONS['smarty_cache_config']['course_media']["flash.tpl"];
    }

    $cache_id = md5($_SESSION['language'].$_GET['chapitre_media_id']) ;

    if (!$smarty->is_cached($_OPTIONS['theme']."/flash.tpl", $cache_id))
    {
        $query = "
        SELECT
        chapitre_media_title
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
        WHERE
        chapitre_media_id=".$_GET['chapitre_media_id']."
        ";

        $rs = $inicrond_db->Execute($query);
        $f = $rs->FetchRow();

        $smarty->assign('chapitre_media_title', $f['chapitre_media_title']);
        $smarty->assign('chapitre_media_id', $_GET['chapitre_media_id']);

        $module_title = $f['chapitre_media_title'] ;

        include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";

        $smarty->display($_OPTIONS['theme']."/flash.tpl", $cache_id);

        $smarty->caching = 0;
    }
    else
    {
        echo "acces denied (1)";
    }
}
else
{
        echo "acces denied (2)";
}


?>