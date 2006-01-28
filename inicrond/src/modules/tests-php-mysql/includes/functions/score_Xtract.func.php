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


/**
* return the score of a result
*
* @param        array  $result_id    contains values
* @param        boolean  $standard    return a string or an array?
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/

function score_that_you_obtained($result_id)
//standard is if you want a string or an array that conaint the two value.
{
    global $_OPTIONS;
    global $inicrond_db;//mysql

    // echo 'score_that_you_obtained $result_id : '.$result_id.'<br /> ' ;

    if(!isset($result_id))
    {
        return FALSE;
    }

    $query = "
    SELECT
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id,
    question_ordering_id,
    short_answer,
    q_type,
    good_points,
    bad_points,
    correcting_method
    FROM
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].",
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering']."
    WHERE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".question_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['question_ordering'].".question_id
    AND
    result_id=".$result_id."
    ";

    $rs = $inicrond_db->Execute($query);

    $count_questions = 0;

    $count_good_question = 0 ;

    while($fetch_result = $rs->FetchRow())  //pop un # num�o d'exercice...
    {
        $question_ordering_id = $fetch_result["question_ordering_id"];
        $question_id = $fetch_result["question_id"];

        if($fetch_result['q_type'] ==
        MODULE_TEST_PHP_MYSQL_CORRECTING_METHOD_WITH_QUESTION_POINTS)//choix multiples..
        {
            if($fetch_result["correcting_method"] == MODULE_TEST_PHP_MYSQL_Q_TYPE_MULTIPLE_CHOICES_QUESTION)

            {
                $count_questions += $fetch_result["good_points"];//points pour la question.

                $query = "
                SELECT
                answer_id,
                a_checked_flag
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering']."
                WHERE
                question_ordering_id=".$question_ordering_id."
                ";

                $query_result_2 = $inicrond_db->Execute($query);

                $count_good_question += $fetch_result["good_points"];

                while($fetch_result_2 = $query_result_2->FetchRow())//pop un # num�o d'exercice...
                {
                    $query = "
                    SELECT
                    answer_id
                    FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
                    WHERE
                    answer_id=".$fetch_result_2["answer_id"]."
                    AND
                    is_good_flag=".$fetch_result_2["a_checked_flag"]."
                    ";

                    $query_result_3 = $inicrond_db->Execute($query);
                    $fetch_result_3 = $query_result_3->FetchRow();

                    if(!isset($fetch_result_3["answer_id"]))
                    {
                        $count_good_question -= $fetch_result["good_points"];
                        $count_good_question += $fetch_result["bad_points"];
                        break;//il l'a mal...
                    }
                }//end while
            }
            elseif($fetch_result["correcting_method"] == MODULE_TEST_PHP_MYSQL_Q_TYPE_SHORT_ANSWER_QUESTION)//correct for each answer...
            {
                $query = "
                SELECT
                answer_id,
                a_checked_flag
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering']."
                WHERE
                question_ordering_id=".$question_ordering_id."
                ";

                $query_result_2 = $inicrond_db->Execute($query);

                while($fetch_result_2 = $query_result_2->FetchRow())//pop un # num�o d'exercice...
                {
                    $query = "
                    SELECT
                    answer_id,
                    pts_amount_for_good_answer,
                    pts_amount_for_bad_answer,
                    is_good_flag
                    FROM
                    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
                    WHERE
                    answer_id=".$fetch_result_2["answer_id"]."
                    ";

                    $query_result_3 = $inicrond_db->Execute($query);
                    $fetch_result_3 = $query_result_3->FetchRow();

                    if($fetch_result_3["is_good_flag"] == $fetch_result_2["a_checked_flag"])
                    {
                        $count_good_question += $fetch_result_3['pts_amount_for_good_answer'];
                    }
                    else
                    {
                        $count_good_question += $fetch_result_3['pts_amount_for_bad_answer'];
                    }

                    $count_questions += $fetch_result_3['pts_amount_for_good_answer'];
                }
            }
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


            if($fetch_result["correcting_method"] ==
             MODULE_TEST_PHP_MYSQL_CORRECTING_METHOD_WITH_QUESTION_POINTS)
            {
                $count_questions += $fetch_result["good_points"];//points pour la question.
                $count_good_question += $fetch_result["good_points"];

                $query = "
                SELECT
                short_answer_name
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
                WHERE
                question_id=".$question_id."
                ";

                $query_result_212 = $inicrond_db->Execute($query);

                while($fetch_result411 = $query_result_212->FetchRow())//pop un # num�o d'exercice...
                {
                    /*
                        the undohtmlentities is called because inicrond is all in utf-8 since 3.3.2
                        it is for backward compatibility.
                    */

                    if(!(preg_match($fetch_result411["short_answer_name"], $short_answer)
                    || preg_match (undohtmlentities($fetch_result411["short_answer_name"]), $short_answer)))
                    {
                        $count_good_question -= $fetch_result["good_points"];
                        $count_good_question += $fetch_result["bad_points"];
                        break;//il l'a mal...
                    }
                }//end while
            }
            elseif($fetch_result["correcting_method"] ==
             MODULE_TEST_PHP_MYSQL_CORRECTING_METHOD_WITH_QUESTION_ANSWERS_POINTS)//correct for each answer...
            {
                $query = "
                SELECT
                short_answer_name,
                pts_amount_for_bad_answer,
                pts_amount_for_good_answer
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
                WHERE
                question_id=".$question_id."
                ";

                $query_result_2 = $inicrond_db->Execute($query);

                while($fetch_result_2 = $query_result_2->FetchRow())//pop un # num�o d'exercice...
                {
                    if(preg_match($fetch_result_2["short_answer_name"], $short_answer)
                    || preg_match(undohtmlentities($fetch_result_2["short_answer_name"]), $short_answer))
                    {
                        $count_good_question += $fetch_result_2['pts_amount_for_good_answer'];
                    }
                    else
                    {
                        $count_good_question += $fetch_result_2['pts_amount_for_bad_answer'];
                    }

                    $count_questions += $fetch_result_2['pts_amount_for_good_answer'];
                }
            }
        }
        elseif($fetch_result['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_SHORT_ANSWER_QUESTION)//r�onse courte
        {
            $count_questions += $fetch_result["good_points"];//points pour la question.
            //obtenir la r�onse.

            $query = "
            SELECT
            short_answer
            FROM
            ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers']."
            WHERE
            question_ordering_id=$question_ordering_id
            ";

            $query_result_3 = $inicrond_db->Execute($query);
            $fetch_result_2 = $query_result_3->FetchRow();

            if(preg_match($fetch_result["short_answer"], $fetch_result_2["short_answer"])
            || preg_match(undohtmlentities($fetch_result["short_answer"]), $fetch_result_2["short_answer"]))
            {
                $count_good_question +=  $fetch_result["good_points"];//bonne r�onse.
            }
            else
            {
                $count_good_question +=  $fetch_result["bad_points"];//bonne r�onse.
            }
        }
        elseif($fetch_result['q_type'] == MODULE_TEST_PHP_MYSQL_Q_TYPE_MEDIA_QUESTION)//flash
        {
            $count_questions += $fetch_result["good_points"];//points pour la question.

            $query = "
            SELECT
            points_obtenu,
            points_max
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

            if( $fetch_result_2['points_max'] != 0)//pour pas diviser par z�o...
            {
                $count_good_question +=
                ( $fetch_result_2['points_obtenu'] / $fetch_result_2['points_max'])*
                $fetch_result["good_points"];//bonne r�onse.
            }
        }
    }


    $myTestResult = new TestResult () ;

    $myTestResult->init ($count_good_question, $count_questions) ;

    //echo 'in the calculus : <br />' ;
    //print_r ($myTestResult) ;
    //echo '<br />' ;

    return $myTestResult ;
}
/**
* update a test result
*
* @param        integer  $result_id    id of the result
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function update_result($result_id)
{
    if(!isset($result_id))
    {
        return FALSE;
    }

    $stuff = score_that_you_obtained($result_id);//return an array.

    global $_OPTIONS;
    global $inicrond_db;//mysql

    //echo '$result_id : '.$result_id.'<br />' ;

    //print_r ($stuff) ;

    $query = "
    UPDATE
    ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
    SET
    your_points=".$stuff->get_your_points ().",
    max_points=".$stuff->get_max_points ()."
    WHERE
    result_id=".$result_id."
    ";

    $inicrond_db->Execute($query);
}

?>