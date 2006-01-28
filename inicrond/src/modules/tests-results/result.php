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
include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/languages/".$_SESSION['language'].'/lang.php';

$smarty->assign("_LANG", $_LANG);
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';

include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/score_Xtract.func.php";
include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/access.function.php";//fonction pour savoir si un �udiant peut faire un test.
include "includes/functions/conversion.function.php";//conversions
include __INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/includes/functions/undohtmlentities.php' ;

include __INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/includes/constants/q_type.php' ;

$is_in_charge_of_user=is_in_charge_of_user($_SESSION['usr_id'], result_2_usr($_GET['result_id']));

include 'includes/classes/TestResult.php' ;

if($is_in_charge_of_user && can_usr_check_sheet($_SESSION['usr_id'], $_GET['result_id']))
{
    //voir une examen...
    if(isset($_GET['result_id']) && isset($_GET['result_id']) && $_GET['result_id'] != ""
    && (int)  $_GET['result_id'] )
    {
        $query = "
        SELECT
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id,
        test_name,
        cours_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id,
        q_rand_flag,
        do_you_show_good_answers
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
        and
        result_id=".$_GET['result_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();

        $result = $is_in_charge_of_user  ? retournerHref(__INICROND_INCLUDE_PATH__."modules/tests-results/results.php?test_id=".$fetch_result['test_id'], $_LANG['tests-results']) : $_LANG['tests-results'];

        $module_title =  $_LANG['see_ex'];
        include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/conversion.function.php";

        $show_good_answers = (is_teacher_of_cours($_SESSION['usr_id'], result_2_cours($_GET['result_id']))
        || ($fetch_result['do_you_show_good_answers'] == 1)) ;

        if($_OPTIONS['smarty_cache_config']['tests-results']["result.tpl"] != 0)
        {
            $smarty->caching = 1;
            $smarty->cache_lifetime = $_OPTIONS['smarty_cache_config']['tests-results']["result.tpl"];
        }

        $cache_id = md5($_SESSION['language'].$_GET['result_id'].$_SESSION['usr_id']) ;

        if(!$smarty->is_cached($_OPTIONS['theme']."/result.tpl", $cache_id))
        {
            //
            //LES INFOS DU CORRIG�..
            //
            $query = "
            SELECT
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id AS usr_id,
            usr_name,
            test_name,
            time_GMT_start,
            time_GMT_end-time_GMT_start,
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id AS test_id,
            result_id
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
            WHERE
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".session_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".session_id
            and
            result_id=". $_GET['result_id'] ."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
            ";

            $rs = $inicrond_db->Execute($query);
            $fetch_result = $rs->FetchRow();

            $smarty->assign('usr_id', ($fetch_result['usr_id']));
            $smarty->assign('result_id', ($fetch_result['result_id']));
            $smarty->assign('test_id', ($fetch_result['test_id']));
            $smarty->assign('test_name', ($fetch_result['test_name']));
            $smarty->assign('date', format_time_stamp($fetch_result['time_GMT_start']));
            $smarty->assign("length", format_time_length($fetch_result['time_GMT_end-time_GMT_start']));
            $smarty->assign("usr_link", retournerHref(__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=".$fetch_result['usr_id'], $fetch_result['usr_name']));

            $score = score_that_you_obtained($_GET['result_id']) ;

            $smarty->assign("score", $score->toString ());

            include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
            include __INICROND_INCLUDE_PATH__."includes/class/form/Checkbox.class.php";

            $module_content .=  "<script language=\"javascript\">
            <!--

            function popup(url,w,h)
            {
                    params ='width='+w+',height='+h+',directories=0,scrollbars=0,location=0,menubar=0,resizable=0,status=0,titlebar=0,toolbar=0';
                    winPop = window.open(url,'pop_up',params);//créer l'objet winpop hehe
                    winPop.moveTo(0, 0);//met la fenetre en haut à gauche
                    winPop.focus();//prend le focus
            }
            //--->
            </script>
            ";

            //
            //LES QUESTIONS
            //

            $query = "
            SELECT
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id,
            question_ordering_id,
            question_name,
            q_type,
            short_answer,
            good_points,
            bad_points,
            chapitre_media_id,
            correcting_method
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].",
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering']."
            WHERE
            result_id=".$_GET['result_id']."
            AND
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".question_id
            ORDER BY ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".q_order_id ASC
            ";

            $rs = $inicrond_db->Execute($query);

            $q_num = 1 ;//le numero des questions

            $questions_list = array();

            while($fetch_result = $rs->FetchRow())  //pop un # num�o d'exercice...
            {
                $question = array();

                $question_ordering_id = $fetch_result["question_ordering_id"];
                $question_id = $fetch_result["question_id"];

                //
                //le #
                //

                $question["q_num"] = $q_num ;

                //la question

                $question["correcting_method"] =        ($fetch_result["correcting_method"]);
                $question['question_name'] =    BBcode_parser($fetch_result['question_name']);
                $question['q_type'] =   ($fetch_result['q_type']);

                $is_good = $fetch_result["good_points"];//les points pour la question.
                $question['points'] =  $fetch_result["good_points"];

                if($fetch_result['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_MULTIPLE_CHOICES_QUESTION)//multiple choices
                {
                    if($fetch_result["correcting_method"] == 1)//with each answer
                    {
                        //get the total score if it is corrected with each answer...
                        $query = "
                        SELECT
                        pts_amount_for_good_answer
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
                        WHERE
                        question_id=".$question_id."
                        ";

                        $query_result_2 = $inicrond_db->Execute($query);

                        $question['points'] = 0;
                        $question["your_points"] = 0;

                        while($it = $query_result_2->FetchRow())
                        {
                            $question['points'] += $it['pts_amount_for_good_answer'];
                        }
                    }
                    else//with the question points
                    {
                        $question["your_points"] = $fetch_result["good_points"];
                    }

                    $query = "
                    SELECT
                    answer_name,
                    a_checked_flag,
                    is_good_flag,
                    pts_amount_for_bad_answer,
                    pts_amount_for_good_answer
                    FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers'].",
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering']."
                    WHERE
                    question_ordering_id=$question_ordering_id
                    AND
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering'].".answer_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers'].".answer_id
                    ORDER BY ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering'].".a_order_id ASC
                    ";

                    $query_result_2 = $inicrond_db->Execute($query);

                    $a_num = 65 ;//la lettre de la r�onse...

                    $answers_tpl = array();

                    $question["is_good"] = 1;

                    while ($fetch_result_2 = $query_result_2->FetchRow())//pop une r�onse
                    {
                        $answer = array();

                        $answer["is_good"] = $fetch_result_2["a_checked_flag"] == $fetch_result_2["is_good_flag"] ;

                        if($fetch_result["correcting_method"] == 1)//with each answers
                        {
                            if($answer["is_good"])
                            {
                                $question["your_points"] += $fetch_result_2['pts_amount_for_good_answer'];
                            }
                            else
                            {
                                $question["your_points"] += $fetch_result_2['pts_amount_for_bad_answer'];
                            }
                        }
                        else//with the question points
                        {
                            if(!$answer["is_good"])
                            {
                                $question["your_points"] = $fetch_result["bad_points"];
                            }
                        }

                        if($show_good_answers)
                        {
                            $answer["correction_color"] =  $answer["is_good"] ? "green" : "red";

                            $answer['pts_amount_for_good_answer'] =$fetch_result_2['pts_amount_for_good_answer']." ".$_LANG['points'];
                            $answer['pts_amount_for_bad_answer'] =  $fetch_result_2['pts_amount_for_bad_answer']." ".$_LANG['points'];
                        }
                        else
                        {
                            $answer["correction_color"] = "#000000";
                        }

                        //
                        //le #
                        //

                        $my_text = new Checkbox();
                        $my_text->set_name("");

                        if($fetch_result_2["a_checked_flag"])//a - t - il cocher � ?
                        {
                            $my_text->checked();//CHECKED
                        }

                        $my_text->validate();
                        $answer["form_o"] = $my_text->get_form_o();

                        $answer["a_num"] = chr($a_num);

                        //
                        //la r�onse
                        //

                        $answer["answer_name"] = BBcode_parser($fetch_result_2["answer_name"]);

                        $a_num++;//incr�ente le # de question

                        $answers_tpl []= $answer;
                    }

                    $question['answers'] =$answers_tpl ;

                    //
                    //FIN DE R�ONSES
                    //
                }
                elseif($fetch_result['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_MULTIPLE_SHORT_ANSWERS_QUESTION)//multiple short answers
                {
                    //get the student's answer...
                    $query = "
                    SELECT
                    short_answer
                    FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers']."
                    WHERE
                    question_ordering_id=".$question_ordering_id."
                    ";

                    $query_result_2 = $inicrond_db->Execute($query);
                    $fetch_result_2 = $query_result_2->FetchRow();

                    $short_answer = $fetch_result_2["short_answer"];

                    $question["given_answer"] = $short_answer;

                    if($fetch_result["correcting_method"] == 1)//with each answer
                    {
                        //get the total score if it is corrected with each answer...
                        $query = "SELECT
                        pts_amount_for_good_answer
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
                        WHERE
                        question_id=".$question_id."

                        ";

                        $query_result_2 = $inicrond_db->Execute($query);

                        $question['points'] = 0;
                        $question["your_points"] = 0 ;
                        while($it = $query_result_2->FetchRow())
                        {

                                $question['points'] += $it['pts_amount_for_good_answer'];
                        }
                    }
                    else//with the question points
                    {
                            $question["your_points"] = $fetch_result["good_points"];
                    }

                    $query = "
                    SELECT
                    short_answer_name,
                    pts_amount_for_bad_answer,
                    pts_amount_for_good_answer
                    FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
                    WHERE
                    question_id=$question_id
                    ";

                    $query_result_2 = $inicrond_db->Execute($query);

                    $answers_tpl = array();

                    $question["is_good"] = 1;

                    while ($fetch_result_2 = $query_result_2->FetchRow())//pop une r�onse
                    {
                        $answer = array();

                        if (preg_match($fetch_result_2["short_answer_name"], $short_answer)
                        || preg_match(undohtmlentities ($fetch_result_2["short_answer_name"]), $short_answer))
                        {
                            $answer["is_good"] = true;
                        }
                        else
                        {
                            $answer["is_good"] = false;
                        }

                        if($fetch_result["correcting_method"] == 1)//with each answer
                        {
                            if($answer["is_good"])
                            {
                                $question["your_points"] += $fetch_result_2['pts_amount_for_good_answer'];
                            }
                            else
                            {
                                $question["your_points"] += $fetch_result_2['pts_amount_for_bad_answer'];
                            }
                        }
                        else//with the question points
                        {
                            if(!$answer["is_good"])
                            {

                                $question["your_points"] = $fetch_result["bad_points"];
                            }

                        }

                        if($show_good_answers)
                        {
                            $answer["correction_color"] =  $answer["is_good"] ? "green" : "red";

                            $answer['pts_amount_for_good_answer'] =$fetch_result_2['pts_amount_for_good_answer']." ".$_LANG['points'];
                            $answer['pts_amount_for_bad_answer'] =  $fetch_result_2['pts_amount_for_bad_answer']." ".$_LANG['points'];
                            $answer["answer_name"] =        $fetch_result_2["short_answer_name"];
                        }
                        else
                        {
                            $answer["correction_color"] = "#000000";
                        }

                        $answers_tpl []= $answer ;
                    }

                    $question['answers'] =$answers_tpl ;
                }
                elseif($fetch_result['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_SHORT_ANSWER_QUESTION)//r�onse courte...
                {
                    $query = "
                    SELECT
                    short_answer
                    FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers']."
                    WHERE
                    question_ordering_id=$question_ordering_id
                    ";

                    $query_result_2 = $inicrond_db->Execute($query);
                    $fetch_result_2 = $query_result_2->FetchRow();

                    /*
                    echo "--<br />\n" ;
                    echo '$fetch_result["short_answer"] '.$fetch_result["short_answer"]. "<br />\n" ;
                    echo '$fetch_result_2["short_answer"] '. $fetch_result_2["short_answer"]."<br />\n" ;
                    echo 'undohtmlentities ($fetch_result["short_answer"] '.undohtmlentities ($fetch_result["short_answer"]). "<br />\n" ;
                    */

                    //preg_match correction...
                    if(preg_match($fetch_result["short_answer"], $fetch_result_2["short_answer"])
                    || preg_match(undohtmlentities ($fetch_result["short_answer"]), $fetch_result_2["short_answer"]))//r�onse mauvaise
                    {
                        $question["is_good"] = 1;
                        $question["your_points"] = $fetch_result["good_points"];
                        $question["correcting_color"]  =$question["is_good"] ? "green" : "red" ;
                    }
                    else
                    {
                        $question["your_points"] = $fetch_result["bad_points"];
                        $question["is_good"] = 0;
                        $question["correcting_color"]  =$question["is_good"] ? "green" : "red" ;
                    }

                    $question["given_answer"] = ($fetch_result_2["short_answer"]);

                    if($show_good_answers)
                    {
                        $question["short_answer"] = $fetch_result["short_answer"];
                    }
                }
                elseif($fetch_result['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_MEDIA_QUESTION)//question flashiii
                {
                    $question["flash"] =  retournerHref("javascript:popup('flash.php?chapitre_media_id=".$fetch_result['chapitre_media_id']."', 790, 590)",
                    $_LANG['animation']);//lien vers l'animation

                    $query = "
                    SELECT
                    points_obtenu,
                    points_max,
                    time_stamp_end-time_stamp_start
                    FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['media_linkage'].",
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
                    WHERE
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['media_linkage'].".score_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores'].".score_id
                    AND
                    question_ordering_id=$question_ordering_id
                    ";

                    $query_result_3 = $inicrond_db->Execute($query);
                    $fetch_result_2 = $query_result_3->FetchRow();

                    $fetch_result_2['points_obtenu'] = isset($fetch_result_2['points_obtenu']) ? $fetch_result_2['points_obtenu'] : 0;
                    $fetch_result_2['points_max'] = isset($fetch_result_2['points_max']) ? $fetch_result_2['points_max'] : 0;

                    if($fetch_result_2['points_max'] != 0)
                    {
                        $question["done"] = 1;
                        $question['points_obtenu'] = $fetch_result_2['points_obtenu'];
                        $question['points_max'] = $fetch_result_2['points_max'];
                        $question["delta_time"] = format_time_length($fetch_result_2['time_stamp_end-time_stamp_start']);

                        $question["percent"] = $fetch_result_2['points_obtenu']/$fetch_result_2['points_max']*$fetch_result["good_points"]."/".$fetch_result["good_points"];

                        $question["your_points"] = $fetch_result_2['points_obtenu']/$fetch_result_2['points_max']*$fetch_result["good_points"];
                    }
                    else//l'exercice n'a pas ��fait...
                    {

                        $question["done"] = 1;
                        $question['points_obtenu'] = $fetch_result_2['points_obtenu'];
                        $question['points_max'] = $fetch_result_2['points_max'];
                        $question["delta_time"] = format_time_length($fetch_result_2['time_stamp_end-time_stamp_start']);

                        $question["percent"] = 0;
                        $question["your_points"] = 0;
                        $question["done"] = 0;
                    }
                }

                $q_num++;//incr�ente le # de question

                $questions_list []= $question;
            }

            //
            //FIN DES QUESTIONS
            //

            $smarty->assign("questions_list" , $questions_list);

        }

        $module_content .= $smarty->fetch($_OPTIONS['theme']."/result.tpl", $cache_id);

        $smarty->caching = 0;
    }
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>