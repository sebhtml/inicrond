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

if(isset($_GET['test_id']) && $_GET['test_id'] != "" && (int) $_GET['test_id']
&& is_teacher_of_cours($_SESSION['usr_id'],test_2_cours($_GET['test_id'])))
{
    if(isset($_POST["from_bank"]))
    {
        include "includes/kernel/add_q_from_bank.php";
    }//fin du if
    if(isset($_POST["envoi"]))//update le test
    {
        include "includes/kernel/update_test.php";
    }

    //allons chercher le titre du cours.
    //

    $query = "SELECT
    test_name,
    cours_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id,
    q_rand_flag,
    available_results,
    available_sheet,
    do_you_show_good_answers,
    test_info
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
    and
    test_id=".$_GET['test_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $cours_id = $fetch_result['cours_id'];//for later.

    $module_title =  $fetch_result['test_name'];

    include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
    include __INICROND_INCLUDE_PATH__."includes/class/form/Text.class.php";

    include __INICROND_INCLUDE_PATH__."includes/class/form/Textarea.class.php";
    include __INICROND_INCLUDE_PATH__."includes/class/form/Select.class.php";
    include __INICROND_INCLUDE_PATH__."includes/class/form/Option.class.php";

    include __INICROND_INCLUDE_PATH__."includes/class/form/sql/Select_with_sql.class.php";

    $test_parameters = array();

    $my_row = array();

    $my_row []=  $_LANG['title'];

    $my_text = new Text();
    $my_text->set_value($fetch_result['test_name']);
    $my_text->set_name('test_name');
    $my_text->validate();
    $my_row []= $my_text->get_form_o();
    $test_parameters []= $my_row;

    $my_row = array();
    $my_row []=  $_LANG['test_info'];
    $my_text = new Textarea();
    $my_text->set_value($fetch_result['test_info']);
    $my_text->set_name('test_info');
    $my_text->set_rows("8");
    $my_text->set_cols("30");
    $my_text->set_text($_LANG['test_info']);
    $my_text->validate();
    $my_row []= $my_text->get_form_o();
    $test_parameters []= $my_row;

    //
    //le flag Q_ANSWER_at_random
    //

    $my_row = array();
    $my_row []= $_LANG['q_rand_flag'];

    $select = new Select();
    $select->set_name('q_rand_flag');


    $my_option = new Option();

    if ($fetch_result['q_rand_flag'] == '0')
    {
        $my_option->selected();//SELECTED
    }

    $my_option->set_value("0");
    $my_option->set_text($_LANG['no']);
    $select->add_option($my_option);

    $my_option = new Option();

    if ($fetch_result['q_rand_flag'] == '1')
    {
        $my_option->selected();//SELECTED
    }

    $my_option->set_value("1");
    $my_option->set_text($_LANG['yes']);
    $select->add_option($my_option);

    $select->validate();

    $my_row []= $select->get_form_o();
    $test_parameters []= $my_row;

    //
    //FIN DU Q_RANDOM_FLAG
    //

    //
    //le flag available_results
    //
    $my_row = array();
    $my_row []= $_LANG['available_results'];


    $select = new Select();
    $select->set_name('available_results');

    $my_option = new Option();

    if ($fetch_result['available_results'] == '0')
    {
            $my_option->selected();//SELECTED
    }

    $my_option->set_value("0");
    $my_option->set_text($_LANG['no']);
    $select->add_option($my_option);

    $my_option = new Option();

    if ($fetch_result['available_results'] == '1')
    {
            $my_option->selected();//SELECTED
    }

    $my_option->set_value("1");
    $my_option->set_text($_LANG['yes']);
    $select->add_option($my_option);

    $select->validate();

    $my_row []= $select->get_form_o();
    $test_parameters []= $my_row;

    //
    //FIN DU  available_results
    //
    //
    //le flag available_results
    //

    $my_row = array();
    $my_row []= $_LANG['do_you_show_good_answers'];


    $select = new Select();
    $select->set_name('do_you_show_good_answers');

    $my_option = new Option();

    if($fetch_result['do_you_show_good_answers'] == '0')
    {
        $my_option->selected();//SELECTED
    }

    $my_option->set_value("0");
    $my_option->set_text($_LANG['no']);
    $select->add_option($my_option);

    $my_option = new Option();

    if($fetch_result['do_you_show_good_answers'] == 1)
    {
        $my_option->selected();//SELECTED
    }

    $my_option->set_value("1");
    $my_option->set_text($_LANG['yes']);
    $select->add_option($my_option);

    $select->validate();

    $my_row []= $select->get_form_o();
    $test_parameters []= $my_row;

    //
    //FIN DU  available_results
    //

    //
    //le flag available_results
    //
    $my_row = array();
    $my_row []= $_LANG['available_sheet'];


    $select = new Select();
    $select->set_name('available_sheet');

    $my_option = new Option();

    if($fetch_result['available_sheet'] == '0')
    {
        $my_option->selected();//SELECTED
    }

    $my_option->set_value("0");
    $my_option->set_text($_LANG['no']);
    $select->add_option($my_option);

    $my_option = new Option();

    if($fetch_result['available_sheet'] == '1')
    {
        $my_option->selected();//SELECTED
    }

    $my_option->set_value("1");
    $my_option->set_text($_LANG['yes']);
    $select->add_option($my_option);

    $select->validate();

    $my_row []= $select->get_form_o();
    $test_parameters []= $my_row;

    //add a question that already exists

    $select = new Select_with_sql();

    //get all the question in thsi course that are not in this test...

    $sqlpp = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id AS VALUE,
    CONCAT(question_CODE, ' ', question_name) AS TEXT
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
    LEFT JOIN
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking']." ON
    (
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking'].".question_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking'].".test_id=".$_GET['test_id']."
    )
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".cours_id=$cours_id
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking'].".question_id IS NULL
    ORDER BY question_CODE ASC
    ";

    $select->sql=($sqlpp);

    $select->name=("question_id");
    $select->inicrond_db=&$inicrond_db;

    $select =  $select->OUTPUT();

    $my_row = array();

    $my_row []= $_LANG['question_bank'];
    $my_row []= $select->get_form_o()."<br /><input type=\"submit\"  name=\"from_bank\" value=\"".$_LANG['add']."\" />";
    $add_qs []= $my_row;

    //end of : add a question that already exists

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
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking'].".test_id=".$_GET['test_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_linking'].".question_id
    ORDER BY q_order_id ASC
    ";

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

        $this_question['question_CODE'] = $fetch_result['question_CODE'];

        $this_question["good_points"] = $fetch_result["good_points"];

        $this_question["bad_points"] = $fetch_result["bad_points"];

        //enlever cette question.
        $this_question['remove'] =
        retournerHref("rm_q.php?question_id=".$fetch_result["question_id"]."&test_id=".$_GET['test_id']."", $_LANG['remove']);

        //monter
        $this_question['get_it_up'] =  retournerHref("q_up.php?question_id=".$fetch_result["question_id"]."&test_id=".$_GET['test_id']."", $_LANG['get_it_up']);

        //descendre
        $this_question['get_it_down'] = retournerHref("q_down.php?question_id=".$fetch_result["question_id"]."&test_id=".$_GET['test_id']."", $_LANG['get_it_down']);

        //edit a question/
        $this_question['edit_a_question'] = retournerHref("edit_a_question.php?question_id=".$fetch_result["question_id"].'&test_id='.$_GET['test_id'], $_LANG['edit_a_question']);

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

        $this_question["question_area"] = $fetch_result['question_name'];

        $q_num++;//incr�ente le # de question
        $questions []= $this_question;
    }

    //
    //FIN DES QUESTIONS
    //

    $smarty->template_dir = 'templates/';

    include __INICROND_INCLUDE_PATH__."includes/class/form/Submit.class.php";

    $my_text = new Submit();
    $my_text->set_value($_LANG['txtBoutonForms_ok']);
    $my_text->set_name("envoi");
    $my_text->set_text("");
    $my_text->validate();

    $smarty->assign('validate', $my_text->get_form_o());
    $smarty->assign('_LANG', $_LANG);

    $smarty->assign('questions', $questions);
    $smarty->assign('test_parameters', $test_parameters);
    $smarty->assign('add_qs', $add_qs);

    $smarty->assign('correcting_method_str', $_LANG['correcting_method_str']);
    $smarty->assign('pts_amount_for_good_answer', $_LANG['pts_amount_for_good_answer']);
    $smarty->assign('pts_amount_for_bad_answer', $_LANG['pts_amount_for_bad_answer']);

    $module_content .= $smarty->fetch($_OPTIONS['theme']."/edit.tpl");
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>