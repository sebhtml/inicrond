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

include "includes/functions/conversion.function.php";

if(isset($_GET["answer_id"]) && $_GET["answer_id"] != "" && (int) $_GET["answer_id"]
&& is_teacher_of_cours($_SESSION['usr_id'],answer_2_cours($_GET["answer_id"])))
{
    $query = "
    SELECT
    question_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
    WHERE
    answer_id=".$_GET["answer_id"].//celui que l'on veut monter
    "
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $question_id = $fetch_result["question_id"];

    $query = "
    DELETE FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
    WHERE
    answer_id=".$_GET["answer_id"]."
    ";

    $inicrond_db->Execute($query);

    if(isset($_GET['test_id']))//GOLD FORM
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
        js_redir("edit_a_test_GOLD.php?test_id=".$_GET['test_id']);
    }
    else
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
        js_redir("edit_a_question.php?question_id=".$question_id);
    }
}

?>