<?php
/*
    $Id: do_it.php 133 2006-02-04 02:47:36Z sebhtml $

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

$smarty->assign("_LANG", $_LANG);

include "includes/functions/random.func.php";
include "includes/functions/access.function.php";//fonction pour savoir si un edutiant peut faire un test
include "includes/functions/conversion.function.php";//conversions...
include __INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/includes/constants/q_type.php' ;
include __INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/includes/functions/inicrond_preg_match_tests_php_mysql.php' ;

//conversions...
//peut faire un test.
include __INICROND_INCLUDE_PATH__."modules/tests-results/includes/functions/conversion.function.php";

include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_inode_group.php";//transfer IDs
include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/test_id_2_inode_id.php";//transfer IDs

include __INICROND_INCLUDE_PATH__.'modules/tests-results/includes/classes/TestResult.php' ;

include __INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/includes/constants/q_type.php' ;
include __INICROND_INCLUDE_PATH__.'modules/tests-php-mysql/includes/constants/correcting_method.php' ;


if(isset($_GET['test_id']) && $_GET['test_id']!="" && (int)$_GET['test_id']
&& is_in_inode_group($_SESSION['usr_id'], test_id_2_inode_id($_GET['test_id'])))//verify here...
{
    //allons chercher le titre du cours.
    //

    $query = "
    SELECT
    test_name,
    cours_name,
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id,
    q_rand_flag,
    available_results,
    available_sheet
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".inode_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".inode_id
    and
    test_id=".$_GET['test_id']."
    AND
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id
    ";

    $rs = $inicrond_db->Execute($query);
    $fetch_result = $rs->FetchRow();

    $module_title =  $fetch_result['test_name'];

    $Q_RANDOM_FLAG = $fetch_result['q_rand_flag'];

    $available_sheet = $fetch_result['available_sheet'];

    //
    //INSERTION DE RESULTAT
    //

    if(!isset($_POST["envoi"]))//formulaire...
    {
        //fonction javascript

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

        $inicrond_mktime = inicrond_mktime();

        $query = "
        INSERT INTO
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
        (
        time_GMT_start,
        time_GMT_end,
        test_id,
        session_id
        )
        VALUES
        (
        ".$inicrond_mktime.",
        ".$inicrond_mktime.",
        ".$_GET['test_id'].",
        ".$_SESSION['session_id']."
        )
        ";

        $inicrond_db->Execute($query);

        $RESULT_ID = $inicrond_db->Insert_ID();

        //
        //FIN DE INSERTION DE RESULTAT
        //

        include __INICROND_INCLUDE_PATH__."includes/class/form/Base.class.php";
        include __INICROND_INCLUDE_PATH__."includes/class/form/Hidden.class.php";

        //le num�o de l'Exercice pas l'�udiant...

        $my_text = new Hidden();
        $my_text->set_name('result_id');
        $my_text->set_value($RESULT_ID);
        $my_text->validate();
        $smarty->assign('result_id', $my_text->get_form_o());

        //questions...

        //
        //LES QUESTIONS
        //

        //obtenir tous les exercies...

        $query = "
        SELECT
        question_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id,
        a_rand_flag,
        q_type,
        good_points,
        bad_points,
        chapitre_media_id,
        correcting_method
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

        $exercices = array();

        include __INICROND_INCLUDE_PATH__."includes/class/form/Textarea.class.php";
        include __INICROND_INCLUDE_PATH__."includes/class/form/Checkbox.class.php";

        while($it = $rs->FetchRow())
        {
            $exercices []= $it;
        }

        if($Q_RANDOM_FLAG && count($exercices) > 1)//il y a t il des questions
        //qu'est-ce que l'on mange pour souper ??
        {
            $exercices = at_random($exercices);//m�ange les exercices...
        }

        $q_num = 1 ;//le numero des questions

        $question_list = array();

        foreach($exercices AS $fetch_result)
        {
            $question = array();

            $question['q_type'] = $fetch_result['q_type'];
            $question["correcting_method"] = $fetch_result["correcting_method"];

            $question_id = $fetch_result["question_id"];

            $A_RANDOM_FLAG = $fetch_result['a_rand_flag'];
            $tmp['points'] = $fetch_result["good_points"];
            $tmp['chapitre_media_id'] = $fetch_result['chapitre_media_id'];

            //
            //INSERTION DE QUESTION
            //

            $query = "
            INSERT INTO
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering']."
            (result_id, question_id, q_order_id)
            VALUES
            (".$RESULT_ID.",".$question_id.",".$q_num.")
            ";

            $inicrond_db->Execute($query);

            //
            //FIN DE INSERTION DE QUESTION
            //

            $question_ordering_id = $inicrond_db->Insert_ID();

            //
            //le #
            //

            $question["q_num"] = $q_num;
            $question['points'] = $tmp['points'];

            //
            //la question
            //

            $question['question_name'] =    BBcode_parser($fetch_result['question_name']);

            //
            //R�ONSES
            //

            if($fetch_result['q_type'] == 0)
            {
                $query = "
                SELECT
                answer_id,
                answer_name,
                pts_amount_for_good_answer,
                pts_amount_for_bad_answer
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
                WHERE
                question_id=".$question_id."
                ORDER BY a_order_id ASC
                ";

                $query_result_2 = $inicrond_db->Execute($query);

                $answers = array();//les cl� des r�onses ...

                if($fetch_result["correcting_method"] == 1)
                {
                    $question['points'] = 0;
                }

                while($it = $query_result_2->FetchRow())
                {
                    $answers []= $it ;

                    if($fetch_result["correcting_method"] == 1)
                    {
                        $question['points'] += $it['pts_amount_for_good_answer'];
                    }
                }

                if($A_RANDOM_FLAG && count($answers) > 1)//il y a t il des r�onses...
                {
                    $answers = at_random($answers);//m�ange les exercices...
                }

                $a_num = 65 ;//la lettre de la r�onse...

                $answers_tpl = array();

                while ($fetch_result_2 = array_shift($answers))//pop une r�onse
                {
                    $answer = array();

                    $answer_id = $fetch_result_2["answer_id"];

                    //
                    //INSERTION DE ANSWER
                    //

                    $query = "
                    INSERT INTO
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering']."
                    (question_ordering_id, answer_id, a_order_id, a_checked_flag)
                    VALUES
                    (".$question_ordering_id.",".$fetch_result_2["answer_id"].",".$a_num.", '0')
                    ";

                    $inicrond_db->Execute($query);

                    //
                    //FIN DE INSERTION DE  ANSWER
                    //

                    //
                    //le #
                    //


                    $my_text = new Checkbox();
                    $my_text->set_name("answer_ordering_id=".$inicrond_db->Insert_ID());
                    $my_text->validate();
                    $answer["form_o"] = $my_text->get_form_o();

                    $answer["a_num"] = chr($a_num);

                    $answer['pts_amount_for_good_answer'] = $fetch_result_2['pts_amount_for_good_answer'];
                    $answer['pts_amount_for_bad_answer'] = $fetch_result_2['pts_amount_for_bad_answer'];
                    //
                    //la r�onse
                    //
                    $answer["answer_name"] = BBcode_parser($fetch_result_2["answer_name"]);

                    $a_num++;//incr�ente le # de

                    $answers_tpl []= $answer;
                }

                $question['answers'] = $answers_tpl;

                //
                //FIN DE R�ONSES
                //

            }
            elseif($fetch_result['q_type'] == 3)//multiple short answers
            {
                if($fetch_result["correcting_method"] == 1)
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

                    while($it = $query_result_2->FetchRow())
                    {

                        $question['points'] += $it['pts_amount_for_good_answer'];
                    }




                }

                $my_text = new Textarea();
                $my_text->set_value("");
                $my_text->set_name("question_ordering_id=".$question_ordering_id."&short_answer");
                $my_text->set_rows("3");
                $my_text->set_cols("60");
                $my_text->validate();
                $question["short_answer"] = $my_text->get_form_o();

            }
            elseif($fetch_result['q_type'] == 1)
            {
                $my_text = new Textarea();
                $my_text->set_value("");
                $my_text->set_name("question_ordering_id=".$question_ordering_id."&short_answer");
                $my_text->set_rows("3");
                $my_text->set_cols("60");
                $my_text->validate();
                $question["short_answer"] = $my_text->get_form_o();

            }
            elseif($fetch_result['q_type'] == 2)//flashi yo
            {
                $question["flash"] .= retournerHref("javascript:popup('".__INICROND_INCLUDE_PATH__."modules/course_media/flash.php?chapitre_media_id=".$tmp['chapitre_media_id']."&question_ordering_id=".$question_ordering_id."', 790, 590)",
                $_LANG['animation']);//lien vers l'animation

                $query = "
                INSERT INTO
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['media_linkage']."
                (question_ordering_id)
                VALUES
                (".$question_ordering_id.")";

                $inicrond_db->Execute($query);
            }

            $q_num++;//incr�ente le # de question

            $questions_list []= $question;
        }

            //
            //FIN DES QUESTIONS
            //

            include __INICROND_INCLUDE_PATH__."includes/class/form/Submit.class.php";

            $my_text = new Submit();
            $my_text->set_value($_LANG['txtBoutonForms_ok']);
            $my_text->set_name("envoi");
            $my_text->set_text("");
            $my_text->validate();
            $smarty->assign("submit" , $my_text->get_form_o());

            $smarty->assign("questions_list" , $questions_list);

            $module_content .= $smarty->fetch($_OPTIONS['theme']."/do_it.tpl");

    }

    //fin du isset envoi
    else
    {
        include "includes/kernel/get_result_in.php";

        include 'includes/functions/undohtmlentities.php' ;

        //send the result to the database.
        include "includes/functions/score_Xtract.func.php";
        //end of it...

        //echo $_POST['result_id'] ;

        update_result($_POST['result_id']);//update the marks in the database...

        //If the student can see his exam, show it right now else go to the list of the test results.

        if(can_usr_check_sheet($_SESSION['usr_id'], $_POST['result_id']))//redir to the sheet.
        {
            include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection

            js_redir(__INICROND_INCLUDE_PATH__."modules/tests-results/result.php?result_id=".$_POST['result_id']) ;
        }
        else
        {
            $module_content .= $_LANG['result_in'];
        }
    }//fin de else
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>