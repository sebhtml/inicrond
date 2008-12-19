<?php
/*
    $Id: edit_a_question.php 86 2005-12-29 17:53:10Z sebhtml $

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

define("__INICROND_INCLUDED__", TRUE);//security
define("__INICROND_INCLUDE_PATH__", "../../");//path
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";//init inicrond kernel
include "includes/languages/".$_SESSION["language"]."/lang.php";//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not
//require lang variables.

$module_title = $_LANG['edit_a_question'];
$module_content = "";

$granted_questions = array();
$granted_answers = array();
$granted_short_answers = array();

include 'includes/functions/check_question_granted.php';
include 'includes/functions/check_answer_granted.php';
include 'includes/functions/check_short_answer_granted.php';

if(check_question_granted($_SESSION['usr_id'], $_GET["question_id"]))
{
    ///update if data is sent.
    if(isset($_POST["envoi"]))//update le test
    {
        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";

        //le bout de code suivant bug au c�ep, observation du mois de d�embre 2004.

        foreach($_POST AS $key => $value)//pour chaque donn�ss.
        {

            if(preg_match("/question_id=(.+)&question_name/", $key, $tokens)
            && check_question_granted($_SESSION['usr_id'], $tokens["1"]))
            //les txt pour questions
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
                SET
                question_name=\"".filter($value)."\"
                WHERE
                question_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/question_id=(.+)&question_CODE/", $key, $tokens)
            && check_question_granted($_SESSION['usr_id'], $tokens["1"]))
            //les txt pour questions
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
                SET
                question_CODE=\"".filter($value)."\"
                WHERE
                question_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/short_answer_id=(.+)&pts_amount_for_bad_answer/", $key, $tokens)
            && check_short_answer_granted($_SESSION['usr_id'], $tokens["1"]))
            //les txt pour les answer.
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
                SET
                pts_amount_for_bad_answer=\"".filter($value)."\"
                WHERE
                short_answer_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/short_answer_id=(.+)&pts_amount_for_good_answer/", $key, $tokens)
            && check_short_answer_granted($_SESSION['usr_id'], $tokens["1"]))//les txt pour les answer.
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
                SET
                pts_amount_for_good_answer=\"".filter($value)."\"
                WHERE
                short_answer_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/question_id=(.+)&correcting_method/", $key, $tokens)
            && check_question_granted($_SESSION['usr_id'], $tokens["1"]))
            //les txt pour questions
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
                SET
                correcting_method='".($value)."'
                WHERE
                question_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/question_id=(.+)&bad_points/", $key, $tokens)
            && check_question_granted($_SESSION['usr_id'], $tokens["1"]))
            //les points
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
                SET
                bad_points=\"".$value."\"
                WHERE
                question_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/question_id=(.+)&good_points/", $key, $tokens)
            && check_question_granted($_SESSION['usr_id'], $tokens["1"]))
            //les points
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
                SET
                good_points=\"".$value."\"
                WHERE
                question_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/question_id=(.+)&short_answer/", $key, $tokens)
            && check_question_granted($_SESSION['usr_id'], $tokens["1"]))
            //la r�onse courte.
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
                SET
                short_answer=\"".filter($value)."\"
                WHERE
                question_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/question_id=(.+)&chapitre_media_id/", $key, $tokens)
            && check_question_granted($_SESSION['usr_id'], $tokens["1"]))
            //la r�onse courte.
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
                SET
                chapitre_media_id=".$value."
                WHERE
                question_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/answer_id=(.+)&is_good_flag/", $key, $tokens)
            && check_answer_granted($_SESSION['usr_id'], $tokens["1"]))
            //les is_good_flag pour les answers
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
                SET
                is_good_flag='$value'
                WHERE
                answer_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/answer_id=(.+)&answer_name/", $key, $tokens)
            && check_answer_granted($_SESSION['usr_id'], $tokens["1"]))
            //les txt pour les answer.
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
                SET
                answer_name=\"".filter($value)."\"
                WHERE
                answer_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/answer_id=(.+)&pts_amount_for_bad_answer/", $key, $tokens)
            && check_answer_granted($_SESSION['usr_id'], $tokens["1"]))
            //les txt pour les answer.
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
                SET
                pts_amount_for_bad_answer=\"".filter($value)."\"
                WHERE
                answer_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/answer_id=(.+)&pts_amount_for_good_answer/", $key, $tokens)
            && check_answer_granted($_SESSION['usr_id'], $tokens["1"]))
            //les txt pour les answer.
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
                SET
                pts_amount_for_good_answer=\"".filter($value)."\"
                WHERE
                answer_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }
            elseif(preg_match("/short_answer_id=(.+)&short_answer_name/", $key, $tokens)
            && check_short_answer_granted($_SESSION['usr_id'], $tokens["1"]))
            //les txt pour les answer.
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
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
            && check_question_granted($_SESSION['usr_id'], $tokens["1"]))
            //les txt pour les answer.
            {
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
                SET
                a_rand_flag='".($value)."'
                WHERE
                question_id=".$tokens["1"]."
                ";

                $inicrond_db->Execute($query);
            }//fin du elseif
        }
    }//end of update test.

    //
    //LES QUESTIONS
    //

    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id,
    question_name,
    a_rand_flag,
    q_type,
    short_answer,
    chapitre_media_id,
    good_points,
    bad_points,
    correcting_method,
    question_CODE
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
    WHERE
    question_id = ".$_GET['question_id']."
    ";

    include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
    include __INICROND_INCLUDE_PATH__."includes/class/form/Text.class.php";

    include __INICROND_INCLUDE_PATH__."includes/class/form/Textarea.class.php";
    include __INICROND_INCLUDE_PATH__."includes/class/form/Select.class.php";
    include __INICROND_INCLUDE_PATH__."includes/class/form/Option.class.php";

    include __INICROND_INCLUDE_PATH__."includes/class/form/sql/Select_with_sql.class.php";

    $rs = $inicrond_db->Execute($query);

    $q_num = 1 ;//le numero des questions

    $questions = array();

    while($fetch_result = $rs->FetchRow())
    {
        //
        //le #
        //

        $this_question = array();

        $this_question["q_number"] = $q_num;

        $my_text = new Text();
        $my_text->set_value($fetch_result['question_CODE']);
        $my_text->set_name("question_id=".$fetch_result["question_id"]."&question_CODE");
        $my_text->set_size("8");
        $my_text->validate();

        $this_question['question_CODE'] = $my_text->get_form_o();

        $my_text = new Text();
        $my_text->set_value($fetch_result["good_points"]);
        $my_text->set_name("question_id=".$fetch_result["question_id"]."&good_points");
        $my_text->set_size("2");
        $my_text->validate();

        $this_question["good_points"] = $my_text->get_form_o();

        $my_text = new Text();
        $my_text->set_value($fetch_result["bad_points"]);
        $my_text->set_name("question_id=".$fetch_result["question_id"]."&bad_points");
        $my_text->set_size("2");
        $my_text->validate();

        $this_question["bad_points"] = $my_text->get_form_o();

        //enlever cette question.

        //
        //la question
        //

        if($fetch_result['q_type'] == 0)
        {
            $this_question["q_type_str"] = $_LANG['multiple_choices_question'];
            $this_question['q_type'] = 0;
        }
        elseif($fetch_result['q_type'] == 1)
        {
            $this_question["q_type_str"] = $_LANG['single_answer_question'];
            $this_question['q_type'] = 1;
        }
        elseif($fetch_result['q_type'] == 2)
        {
            $this_question["q_type_str"] = $_LANG['flash_based_question'];
            $this_question['q_type'] = 2;
        }
        elseif($fetch_result['q_type'] == 3)
        {
            $this_question["q_type_str"] = $_LANG['multiple_short_answers_q'];
            $this_question['q_type'] = 3;
        }

        $this_question['question_name'] = $_LANG['question'];

        $my_text = new Textarea();

        $my_text->set_value($fetch_result['question_name']);
        $my_text->set_name("question_id=".$fetch_result["question_id"]."&question_name");
        $my_text->set_rows("3");
        $my_text->set_cols("60");
        $my_text->validate();
        $this_question["question_area"] = $my_text->get_form_o();

        if($fetch_result['q_type'] == 0)
        {
            //
            //le flag a_ANSWER_at_random
            //

            $this_question["a_rand_flag_str"] = $_LANG['a_rand_flag'];

            $select = new Select();
            $select->set_name("question_id=".$fetch_result["question_id"]."&a_rand_flag");

            $my_option = new Option();

            if($fetch_result['a_rand_flag'] == 0)
            {
                $my_option->selected();//SELECTED
            }

            $my_option->set_value("0");
            $my_option->set_text($_LANG['no']);
            $select->add_option($my_option);

            $my_option = new Option();

            if($fetch_result['a_rand_flag'] == 1)
            {
                $my_option->selected();//SELECTED
            }

            $my_option->set_value("1");
            $my_option->set_text($_LANG['yes']);
            $select->add_option($my_option);

            $select->validate();

            $this_question["a_rand_flag_form_o"] =  $select->get_form_o();

            //
            //FIN DU a_RANDOM_FLAG
            //

            //
            //le flag a_ANSWER_at_random
            //

            $select = new Select();
            $select->set_name("question_id=".$fetch_result["question_id"]."&correcting_method");

            $my_option = new Option();

            if($fetch_result["correcting_method"] == 0)
            {
                $my_option->selected();//SELECTED
            }

            $my_option->set_value("0");
            $my_option->set_text($_LANG['correcting_method_0']);
            $select->add_option($my_option);

            $my_option = new Option();

            if($fetch_result["correcting_method"] == 1)
            {
                $my_option->selected();//SELECTED
            }

            $my_option->set_value("1");
            $my_option->set_text($_LANG['correcting_method_1']);
            $select->add_option($my_option);

            $select->validate();

            $this_question["correcting_method_form_o"] =  $select->get_form_o();

            //
            //FIN DU a_RANDOM_FLAG
            //

            //
            //CHOIX DE R?ONSES
            //

            //ajouter une r?onse...

            $this_question['add_answer'] = retournerHref("add_a.php?question_id=".$fetch_result["question_id"], $_LANG['add_answer']);

            //
            //R?ONSES
            //

            $query = "
            SELECT
            answer_id,
            answer_name,
            is_good_flag,
            pts_amount_for_bad_answer,
            pts_amount_for_good_answer
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
            WHERE
            question_id=".$fetch_result["question_id"]."
            ORDER BY a_order_id ASC
            ";

            $query_result_2 = $inicrond_db->Execute($query);

            $a_num = 65 ;//la lettre de la r?onse...

            $this_question['answers'] = array();

            while($fetch_result_2 = $query_result_2->FetchRow())
            {
                //
                //le #
                //

                $this_answer = array();

                $this_answer["id"] = chr($a_num);

                //
                //la r?onse
                //

                $my_text = new Textarea();

                $my_text->set_value($fetch_result_2["answer_name"]);
                $my_text->set_name("answer_id=".$fetch_result_2["answer_id"]."&answer_name");
                $my_text->set_rows("2");
                $my_text->set_cols("60");
                $my_text->validate();

                $this_answer["form_o"] = $my_text->get_form_o();

                $my_text = new Text();
                $my_text->set_value($fetch_result_2['pts_amount_for_good_answer']);
                $my_text->set_name("answer_id=".$fetch_result_2["answer_id"]."&pts_amount_for_good_answer");
                $my_text->set_size("2");
                $my_text->validate();

                $this_answer["pts_amount_for_good_answer_form_o"] = $my_text->get_form_o();

                $my_text = new Text();
                $my_text->set_value($fetch_result_2['pts_amount_for_bad_answer']);
                $my_text->set_name("answer_id=".$fetch_result_2["answer_id"]."&pts_amount_for_bad_answer");
                $my_text->set_size("2");
                $my_text->validate();

                $this_answer["pts_amount_for_bad_answer_form_o"] = $my_text->get_form_o();

                //
                //LE FLAG BONNE R?ONSE
                //

                $select = new Select();
                $select->set_name("answer_id=".$fetch_result_2["answer_id"]."&is_good_flag");

                $my_option = new Option();

                if($fetch_result_2["is_good_flag"] == 0)
                {
                    $my_option->selected();//SELECTED
                }

                $my_option->set_value("0");
                $my_option->set_text($_LANG['bad_answer']);
                $select->add_option($my_option);

                $my_option = new Option();

                if($fetch_result_2["is_good_flag"] == 1)
                {
                    $my_option->selected();//SELECTED
                }

                $my_option->set_value("1");
                $my_option->set_text($_LANG['good_answer']);
                $select->add_option($my_option);

                $select->validate();

                $this_answer["is_good_flag"] = $select->get_form_o();

                //
                //FIN DU FLAG BONNE R?ONSE
                //

                //enlever cette r?onse
                $this_answer['remove'] =  retournerHref("rm_a.php?answer_id=".$fetch_result_2["answer_id"], $_LANG['remove']);

                //monter
                $this_answer['get_it_up'] =  retournerHref("a_up.php?answer_id=".$fetch_result_2["answer_id"], $_LANG['get_it_up']);

                //descendre
                $this_answer['get_it_down'] =  retournerHref("a_down.php?answer_id=".$fetch_result_2["answer_id"], $_LANG['get_it_down']);

                $a_num++;//incr?ente le # de question

                $this_question['answers'] []= $this_answer;
            }
        }//fin du if pour les choix de r?onses
        elseif($fetch_result['q_type'] == 3)
        {
            $select = new Select();
            $select->set_name("question_id=".$fetch_result["question_id"]."&correcting_method");

            $my_option = new Option();

            if($fetch_result["correcting_method"] == 0)
            {
                $my_option->selected();//SELECTED
            }

            $my_option->set_value("0");
            $my_option->set_text($_LANG['correcting_method_0']);
            $select->add_option($my_option);

            $my_option = new Option();

            if($fetch_result["correcting_method"] == 1)
            {
                $my_option->selected();//SELECTED
            }

            $my_option->set_value("1");
            $my_option->set_text($_LANG['correcting_method_1']);
            $select->add_option($my_option);

            $select->validate();

            $this_question["correcting_method_form_o"] =  $select->get_form_o();

            //
            //FIN DU a_RANDOM_FLAG
            //

            //
            //CHOIX DE R?ONSES
            //

            //ajouter une r?onse...
            $this_question['add_answer'] = retournerHref("add_short_a.php?question_id=".$fetch_result["question_id"], $_LANG['add_answer']);

            //
            //R?ONSES
            //
            $query = "
            SELECT
            short_answer_id,
            short_answer_name,
            pts_amount_for_bad_answer,
            pts_amount_for_good_answer
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
            WHERE
            question_id=".$fetch_result["question_id"]."
            ";

            $query_result_2 = $inicrond_db->Execute($query);

            //$a_num = 65 ;//la lettre de la r?onse...
            $this_question['answers'] = array();

            while($fetch_result_2 = $query_result_2->FetchRow())
            {
                //
                //le #
                //

                $this_answer = array();

                //
                //la r?onse
                //

                $my_text = new Textarea();

                $my_text->set_value($fetch_result_2["short_answer_name"]);
                $my_text->set_name("short_answer_id=".$fetch_result_2["short_answer_id"]."&short_answer_name");
                $my_text->set_rows("2");
                $my_text->set_cols("60");
                $my_text->validate();

                $this_answer["form_o"] = $my_text->get_form_o();

                $my_text = new Text();
                $my_text->set_value($fetch_result_2['pts_amount_for_good_answer']);
                $my_text->set_name("short_answer_id=".$fetch_result_2["short_answer_id"]."&pts_amount_for_good_answer");
                $my_text->set_size("2");
                $my_text->validate();

                $this_answer["pts_amount_for_good_answer_form_o"] = $my_text->get_form_o();

                $my_text = new Text();
                $my_text->set_value($fetch_result_2['pts_amount_for_bad_answer']);
                $my_text->set_name("short_answer_id=".$fetch_result_2["short_answer_id"]."&pts_amount_for_bad_answer");
                $my_text->set_size("2");
                $my_text->validate();

                $this_answer["pts_amount_for_bad_answer_form_o"] = $my_text->get_form_o();

                //
                //LE FLAG BONNE R?ONSE
                //

                //enlever cette r?onse

                $this_answer['remove'] =  retournerHref("rm_short_a.php?short_answer_id=".$fetch_result_2["short_answer_id"], $_LANG['remove']);

                $this_question['answers'] []= $this_answer;
            }
        }//fin du if pour les choix de r?onses
        ///////////////////////
        elseif($fetch_result['q_type'] == 1)
        {
            $this_question["answer_str"] = $_LANG['answer'];

            $my_text = new Textarea();
            $my_text->set_value($fetch_result["short_answer"]);
            $my_text->set_name("question_id=".$fetch_result["question_id"]."&short_answer");
            $my_text->set_rows("3");
            $my_text->set_cols("60");
            $my_text->validate();

            $this_question["answer_form_o"] = $my_text->get_form_o();
        }
        elseif($fetch_result['q_type'] == 2)
        {
            $select = new Select();
            $select->set_name("question_id=".$fetch_result["question_id"]."&chapitre_media_id");

            $query = "
            SELECT
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].".chapitre_media_id AS value,
            chapitre_media_title AS text,
            file_name
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."inode_id
            and
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id=".$_GET['question_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id
            ORDER BY chapitre_media_title ASC
            ";

            $query_result_2 = $inicrond_db->Execute($query);

            while($fetch_result_2 = $query_result_2->FetchRow())
            {
                $my_option = new Option();

                if($fetch_result_2["value"] == $fetch_result['chapitre_media_id'])
                {
                        $my_option->selected();//SELECTED
                }

                $my_option->set_value($fetch_result_2["value"]);
                $my_option->set_text($fetch_result_2["text"]." [".$fetch_result_2['file_name']."]");
                $select->add_option($my_option);
            }

            $select->validate();

            $this_question["swf_form_o"] = $select->get_form_o();
        }

        //
        //FIN DE R?ONSES
        //

        $q_num++;//incr?ente le # de question
        $questions []= $this_question;
    }

    //
    //FIN DES QUESTIONS
    //

    $smarty->assign('questions', $questions);
    $smarty->assign('_LANG', $_LANG);
    $smarty->assign('correcting_method_str', $_LANG['correcting_method_str']);
    $smarty->assign('pts_amount_for_good_answer', $_LANG['pts_amount_for_good_answer']);
    $smarty->assign('pts_amount_for_bad_answer', $_LANG['pts_amount_for_bad_answer']);

    $module_content .= $smarty->fetch($_OPTIONS['theme']."/edit_a_question.tpl");

}//end of check if can edit the question...

include "".__INICROND_INCLUDE_PATH__."includes/kernel/post_modulation.php";

?>