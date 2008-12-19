<?php
/*
    $Id: update_test_GOLD.php 85 2005-12-27 03:22:23Z sebhtml $

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

if(__INICROND_INCLUDED__ && isset($_GET["test_id"]))
{
    include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

    $query = "UPDATE
    ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["tests"]."
    SET
    test_name=\"".filter($_POST["test_name"])."\",
    test_info=\"".filter($_POST["test_info"])."\",
    q_rand_flag='".$_POST["q_rand_flag"]."',
    available_results='".$_POST["available_results"]."',
    available_sheet='".$_POST["available_sheet"]."',
    do_you_show_good_answers='".$_POST["do_you_show_good_answers"]."',
    time_GMT_edit=".inicrond_mktime()."
    WHERE
    test_id=".$_GET["test_id"]."
    ";

    $inicrond_db->Execute($query);

    /*
        Here I check if each question, each short answer and each answer can be updated by the current user.
    */

    $granted_questions = array();
    $granted_answers = array();
    $granted_short_answers = array();

    include 'includes/functions/check_question_granted.php';
    include 'includes/functions/check_answer_granted.php';
    include 'includes/functions/check_short_answer_granted.php';

    //le bout de code suivant bug au c�ep, observation du mois de d�embre 2004.
    //met toutes les r�onses pas bonnes pour ce test...

    foreach ($_POST AS $key => $value)//pour chaque donn�ss.
    {
        if(preg_match("/question_id=(.+)&question_name/", $key, $tokens) //les txt pour questions
        && check_question_granted($_SESSION["usr_id"], $tokens["1"]))
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
            SET
            question_name=\"".filter($value)."\"
            WHERE
            question_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/question_id=(.+)&question_CODE/", $key, $tokens)
        && check_question_granted($_SESSION["usr_id"], $tokens["1"]))
        //les txt pour questions
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
            SET
            question_CODE=\"".filter($value)."\"
            WHERE
            question_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/short_answer_id=(.+)&pts_amount_for_bad_answer/", $key, $tokens)
        && check_short_answer_granted($_SESSION["usr_id"], $tokens["1"]))
        //les txt pour les answer.
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["multiple_short_answers"]."
            SET
            pts_amount_for_bad_answer=\"".filter($value)."\"
            WHERE
            short_answer_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/short_answer_id=(.+)&pts_amount_for_good_answer/", $key, $tokens)
        && check_short_answer_granted($_SESSION["usr_id"], $tokens["1"]))
        //les txt pour les answer.
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["multiple_short_answers"]."
            SET
            pts_amount_for_good_answer=\"".filter($value)."\"
            WHERE
            short_answer_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/question_id=(.+)&correcting_method/", $key, $tokens)
        && check_question_granted($_SESSION["usr_id"], $tokens["1"]))
        //les txt pour questions
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
            SET
            correcting_method='".($value)."'
            WHERE
            question_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/question_id=(.+)&bad_points/", $key, $tokens)
        && check_question_granted($_SESSION["usr_id"], $tokens["1"]))
        //les points
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
            SET
            bad_points=\"".$value."\"
            WHERE
            question_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/question_id=(.+)&good_points/", $key, $tokens)
        && check_question_granted($_SESSION["usr_id"], $tokens["1"]))
        //les points
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
            SET
            good_points=\"".$value."\"
            WHERE
            question_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/question_id=(.+)&short_answer/", $key, $tokens)
        && check_question_granted($_SESSION["usr_id"], $tokens["1"]))
        //la r�onse courte.
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
            SET
            short_answer=\"".filter($value)."\"
            WHERE
            question_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/question_id=(.+)&chapitre_media_id/", $key, $tokens)
        && check_question_granted($_SESSION["usr_id"], $tokens["1"]))
        //la r�onse courte.
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
            SET
            chapitre_media_id=".$value."
            WHERE
            question_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/answer_id=(.+)&is_good_flag/", $key, $tokens)
        && check_answer_granted($_SESSION["usr_id"], $tokens["1"]))
        //les is_good_flag pour les answers
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["answers"]."
            SET
            is_good_flag='$value'
            WHERE
            answer_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/answer_id=(.+)&answer_name/", $key, $tokens)
        && check_answer_granted($_SESSION["usr_id"], $tokens["1"]))
        //les txt pour les answer.
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["answers"]."
            SET
            answer_name=\"".filter($value)."\"
            WHERE
            answer_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/answer_id=(.+)&pts_amount_for_bad_answer/", $key, $tokens)
        && check_answer_granted($_SESSION["usr_id"], $tokens["1"]))
        //les txt pour les answer.
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["answers"]."
            SET
            pts_amount_for_bad_answer=\"".filter($value)."\"
            WHERE
            answer_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/answer_id=(.+)&pts_amount_for_good_answer/", $key, $tokens)
        && check_answer_granted($_SESSION["usr_id"], $tokens["1"]))
        //les txt pour les answer.
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["answers"]."
            SET
            pts_amount_for_good_answer=\"".filter($value)."\"
            WHERE
            answer_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }
        elseif(preg_match("/short_answer_id=(.+)&short_answer_name/", $key, $tokens)
        && check_short_answer_granted($_SESSION["usr_id"], $tokens["1"]))
        //les txt pour les answer.
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["multiple_short_answers"]."
            SET
            short_answer_name=\"".filter($value)."\"
            WHERE
            short_answer_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }

        //
        //mettre �jour les flag a_random
        //
        elseif(preg_match("/question_id=(.+)&a_rand_flag/", $key, $tokens)
        && check_question_granted($_SESSION["usr_id"], $tokens["1"]))
        //les txt pour les answer.
        {
            $query = "
            UPDATE
            ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["questions"]."
            SET
            a_rand_flag='".($value)."'
            WHERE
            question_id=".$tokens["1"]."
            ";

            $inicrond_db->Execute($query);
        }//fin du elseif
    }
}

?>