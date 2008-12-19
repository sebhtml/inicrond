<?php
/*
    $Id: add_q_GOLD.php 85 2005-12-27 03:22:23Z sebhtml $

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

define("__INICROND_INCLUDED__", TRUE);
define("__INICROND_INCLUDE_PATH__", "../../");
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";
include "includes/languages/".$_SESSION["language"]."/lang.php";

include "includes/functions/conversion.function.php";

if(isset($_GET["test_id"]) //test_id au moins
&& $_GET["test_id"] != "" //pas de chaîne vide
&& (int) $_GET["test_id"]  //changement de type
&& is_teacher_of_cours($_SESSION["usr_id"],test_2_cours($_GET["test_id"]))
//le type existe ??
&& ($_GET["q_type"] == 0 || $_GET["q_type"] == 1 || $_GET["q_type"] == 2 || $_GET["q_type"] == 3))
{
    //get the courses _id
    $query = "
    SELECT
    cours_id
    FROM
    ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"].",
    ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inode_elements"]."
    WHERE
    test_id=".$_GET["test_id"]."
    and
    ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"].".inode_id = ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["inode_elements"].".inode_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $query = "
    INSERT INTO
    ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
    (
    question_name,
    q_type,
    cours_id
    )
    VALUES
    (
    \"\",
    ".$_GET["q_type"].",
    ".$fetch_result["cours_id"]."
    )
    ";

    $inicrond_db->Execute($query);

    $question_id = $inicrond_db->Insert_ID();

    $query = "
    INSERT INTO
    ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["question_linking"]."
    (test_id, question_id, q_order_id)
    VALUES
    (".$_GET["test_id"].", ".$question_id.", $question_id);
    " ;

    //insert the q_link.
    $inicrond_db->Execute($query);

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

    js_redir("edit_a_test_GOLD.php?test_id=".$_GET["test_id"]);
}

?>
