<?php
/*
    $Id: secure_flash_to_php.php 82 2005-12-24 21:48:25Z sebhtml $

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

echo "receiving data...<br />";

if (!isset($_GET['points_max']) )
{
    echo "points max not set<br />";
}
elseif (!isset($_GET['points_obtenu']) )
{
    echo "points_obtenu not set<br />";
}
elseif (!isset($_GET["secure_str"]) )
{
    echo "secure_str not set<br />";
}
else
{
    $query = "
    UPDATE
    ".
    $_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
    SET
    points_max=".$_GET['points_max'].",
    points_obtenu=".$_GET['points_obtenu'].",
    time_stamp_end=".inicrond_mktime()."
    WHERE
    secure_str='".$_GET["secure_str"]."'
    AND
    points_max=0
    ";

    $inicrond_db->Execute($query);

    if (isset($_SESSION["question_ordering_id"]) &&
    $_SESSION["question_ordering_id"] != "" &&
    (int) $_SESSION["question_ordering_id"])
    {
        //get de score_id

        $query = "
        SELECT
        score_id
        FROM
        ".
        $_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
        WHERE
        secure_str='".$_GET["secure_str"]."'
        ";

        $rs = $inicrond_db->Execute($query);
        $f = $rs->FetchRow();

        //met �jour le score si il n'a pas ��fait encore...
        echo "updating for the test...<br />";

        $query = "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['media_linkage']."
        SET
        score_id=".$f['score_id']."
        WHERE
        question_ordering_id=".$_SESSION["question_ordering_id"]."
        AND
        score_id=0
        ";

        $r = $inicrond_db->Execute($query);
    }

    //insert a new marks , prepare for it...
    include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";

    $HEXA_TAG = hex_gen_32();//hexadecimal string

    $_SESSION["secure_str"] = $HEXA_TAG;//for security reaosns.

    //die($_SESSION['session_id']);
    $inicrond_mktime = inicrond_mktime();
    $query = "
    INSERT INTO
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
    (
    usr_id,
    session_id,
    chapitre_media_id,
    time_stamp_start,
    time_stamp_end,
    secure_str
    )
    VALUES
    (
    ".$_SESSION['usr_id'].",
    ".$_SESSION['session_id'].",
    ".$_SESSION['chapitre_media_id'].",
    ".$inicrond_mktime.",
    ".$inicrond_mktime.",
    '$HEXA_TAG'
    )
    ";

    $inicrond_db->Execute($query);

    $score_id = $inicrond_db->Insert_ID();//for later

    $_SESSION['score_id'] = $score_id;
}

$module_title = "secure_flash_to_php.php";

include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";

?>