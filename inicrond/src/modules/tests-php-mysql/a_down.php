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
    //------------
    //on trouve dans quelle section est la discussion demandée.
    //----------

    //obtention du test_id

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
    SELECT
    a_order_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
    WHERE
    answer_id=".$_GET["answer_id"].//celui que l'on veut descendre
    "
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $order_id_present = $fetch_result["a_order_id"];//le order id pr�ent...

    $query = "
    SELECT
    MIN(a_order_id)
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
    WHERE
    a_order_id>".$order_id_present.//celui qui est avant
    "
    AND
    question_id=".$question_id."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $order_id_avant = $fetch_result["MIN(a_order_id)"];

    if(isset($fetch_result["MIN(a_order_id)"]))//est-ce qu'il y a quelque chose avant.
    {
        //on va chercher la question avant.

        $query = "
        SELECT
        answer_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
        WHERE
        a_order_id=".$order_id_avant.//celui qui est avant
        "
        AND
        question_id=".$question_id."
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        $forum_discussion_id_avant = $fetch_result["answer_id"];

        $query = //on met le order id du présent à celui avant.
        "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
        SET
        a_order_id=".$order_id_avant."
        WHERE
        answer_id=".$_GET["answer_id"].//celui qui est avant
        "
        ";

        $inicrond_db->Execute($query);

        $query = //celui qui est en haut descend
        "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
        SET
        a_order_id=".$order_id_present."
        WHERE
        answer_id=".$forum_discussion_id_avant."
        ";

        $inicrond_db->Execute($query);
    }

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