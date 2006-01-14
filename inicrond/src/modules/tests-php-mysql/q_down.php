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

if(isset($_GET["question_id"]) && $_GET["question_id"] != "" && (int) $_GET["question_id"]
&& is_teacher_of_cours($_SESSION['usr_id'],question_2_cours($_GET["question_id"])))
{
    //------------
    //on trouve dans quelle section est la discussion demandée.
    //----------

    //obtention du test_id

    $test_id = $_GET['test_id'];

    $query = "
    SELECT
    q_order_id
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking']."
    WHERE
    question_id=".$_GET["question_id"].//celui que l'on veut monter
    "
    AND
    test_id=$test_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $order_id_present = $fetch_result["q_order_id"];//le order id pr�ent...

    $query = "
    SELECT
    MIN(q_order_id)
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking']."
    WHERE
    q_order_id>".$order_id_present.//celui qui est avant
    "
    AND
    test_id=".$test_id."
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $order_id_avant = $fetch_result["MIN(q_order_id)"];

    if(isset($fetch_result["MIN(q_order_id)"]))//est-ce qu'il y a quelque chose avant.
    {
        //on va chercher la question avant

        $query = "
        SELECT
        question_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking']."
        WHERE
        q_order_id=".$order_id_avant.//celui qui est avant
        "
        AND
        test_id=".$test_id."
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        $forum_discussion_id_avant = $fetch_result["question_id"];

        $query = //on met le order id du présent à celui avant.
        "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking']."
        SET
        q_order_id=".$order_id_avant."
        WHERE
        question_id=".$_GET["question_id"].//celui qui est avant
        "
        AND
        test_id=".$test_id."
        ";

        $inicrond_db->Execute($query);

        $query = //celui qui est en haut descend
        "
        UPDATE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking']."
        SET
        q_order_id=".$order_id_present."
        WHERE
        question_id=".$forum_discussion_id_avant."
        AND
        test_id=".$test_id."";

        $inicrond_db->Execute($query);
    }

    $inicrond_db->Execute($query);

    include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
    js_redir(__INICROND_INCLUDE_PATH__."modules/tests-php-mysql/edit_a_test_GOLD.php?test_id=".$_GET['test_id']);
}

?>