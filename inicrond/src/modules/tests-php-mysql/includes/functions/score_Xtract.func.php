<?php
//$Id$




/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

//
//---------------------------------------------------------------------
*/
if(__INICROND_INCLUDED__)
{
        /**
        * return the score of a result
        *
        * @param        array  $result_id    contains values
        * @param        boolean  $standard    return a string or an array?
        * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
        * @version      1.0.0
        */
        
	function score_that_you_obtained($result_id, $standard = TRUE)
	//standard is if you want a string or an array that conaint the two value.
	{
                if(!isset($result_id))
                {
                        return FALSE;
                }
                
                global $_OPTIONS;
                global $_RUN_TIME, $inicrond_db;//mysql
                
                $query = "SELECT
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
                
                while($fetch_result = $rs->FetchRow())  //pop un # numéro d'exercice...
                {
                        $question_ordering_id = $fetch_result["question_ordering_id"];
                        $question_id = $fetch_result["question_id"];
                        
                        
                        //die($count_questions);
                        
                        if($fetch_result['q_type'] == 0)//choix multiples..
                        {
                                if($fetch_result["correcting_method"] == 0)
                                
                                {
                                        $count_questions += $fetch_result["good_points"];//points pour la question.
                                        $query = "SELECT
                                        answer_id,
                                        a_checked_flag
                                        FROM
                                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering']."
                                        WHERE 
                                        question_ordering_id=".$question_ordering_id."
                                        ";
                                        
                                        $query_result_2 = $inicrond_db->Execute($query);	
                                        
                                        
                                        
                                        $count_good_question += $fetch_result["good_points"];
                                        
                                        while($fetch_result_2 = $query_result_2->FetchRow())//pop un # numéro d'exercice...
                                        {
                                                
                                                $query = "SELECT
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
                                elseif($fetch_result["correcting_method"] == 1)//correct for each answer...
                                {
                                        $query = "SELECT
                                        answer_id,
                                        a_checked_flag
                                        
                                        FROM
                                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answer_ordering']."
                                        WHERE 
                                        question_ordering_id=".$question_ordering_id."
                                        ";
                                        
                                        $query_result_2 = $inicrond_db->Execute($query);	
                                        
                                        
                                        
                                        //$count_good_question += $fetch_result['points'];
                                        
                                        while($fetch_result_2 = $query_result_2->FetchRow())//pop un # numéro d'exercice...
                                        {
                                                
                                                $query = "SELECT
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
                        
                        elseif($fetch_result['q_type'] == 3)//multiple short answers
                        {
                                //get the student's answer...
                                $query = "SELECT
                                short_answer	
                                FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers']."
                                WHERE 
                                question_ordering_id=".$question_ordering_id."
                                ";
                                
                                $query_result_2 = $inicrond_db->Execute($query);	
                                $fetch_result_2 = $query_result_2->FetchRow();
                                $short_answer = $fetch_result_2["short_answer"];
                                
                                
                                
                                if($fetch_result["correcting_method"] == 0)
                                {
                                        $count_questions += $fetch_result["good_points"];//points pour la question.
                                        
                                        
                                        
                                        $count_good_question += $fetch_result["good_points"];
                                        
                                        $query = "SELECT
                                        short_answer_name
                                        FROM
                                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
                                        WHERE 
                                        question_id=".$question_id."
                                        ";
                                        
                                        $query_result_212 = $inicrond_db->Execute($query);
                                        
                                        while($fetch_result411 = $query_result_212->FetchRow())//pop un # numéro d'exercice...
                                        {
                                                
                                                
                                                if(!preg_match(
                                                $fetch_result411["short_answer_name"],
                                                $short_answer
                                                ))
                                                {
                                                        $count_good_question -= $fetch_result["good_points"];
                                                        $count_good_question += $fetch_result["bad_points"];
                                                        break;//il l'a mal...
                                                }
                                                
                                        }//end while
                                        
                                }
                                elseif($fetch_result["correcting_method"] == 1)//correct for each answer...
                                {
                                        $query = "SELECT
                                        short_answer_name,
                                        pts_amount_for_bad_answer,
                                        pts_amount_for_good_answer	
                                        FROM
                                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
                                        WHERE 
                                        question_id=".$question_id."
                                        ";
                                        
                                        $query_result_2 = $inicrond_db->Execute($query);	
                                        
                                        
                                        
                                        //$count_good_question += $fetch_result['points'];
                                        
                                        while($fetch_result_2 = $query_result_2->FetchRow())//pop un # numéro d'exercice...
                                        {
                                                if(preg_match(
                                                $fetch_result_2["short_answer_name"],
                                                $short_answer
                                                ))
                                                {
                                                        $count_good_question += $fetch_result_2['pts_amount_for_good_answer'];
                                                        /*
                                                        echo $fetch_result_2["short_answer_name"]."<br />";
                                                        exit();
                                                        */
                                                }
                                                else
                                                {
                                                        $count_good_question += $fetch_result_2['pts_amount_for_bad_answer'];
                                                }
                                                $count_questions += $fetch_result_2['pts_amount_for_good_answer'];
                                                
                                        }
                                        
                                }
                                
                        }
                        elseif($fetch_result['q_type'] == 1)//réponse courte
                        {
                                $count_questions += $fetch_result["good_points"];//points pour la question.
                                //obtenir la réponse.
                                /*
                                CREATE TABLE short_answers (
                                
                                #liaison avec les results
                                question_ordering_id BIGINT UNSIGNED ,
                                KEY question_ordering_id (question_ordering_id),
                                
                                
                                #pour les réponses courtes
                                short_answer VARCHAR(255)
                                
                                
                                )TYPE=MyISAM;
                                */
                                $query = "SELECT
                                short_answer
                                FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['short_answers']."
                                WHERE 
                                question_ordering_id=$question_ordering_id
                                
                                ";
                                
                                $query_result_3 = $inicrond_db->Execute($query);	
                                $fetch_result_2 = $query_result_3->FetchRow();
                                
                                /*
                                echo $fetch_result["short_answer"]."<br />"	;
                                echo $fetch_result_2["short_answer"]."<br />"	;
                                exit();
                                */
                                
                                if(preg_match($fetch_result["short_answer"], $fetch_result_2["short_answer"]))
                                {
                                        $count_good_question +=  $fetch_result["good_points"];//bonne réponse.
                                }
                                else
                                {
                                        $count_good_question +=  $fetch_result["bad_points"];//bonne réponse.
                                }
                                
                        }
                        elseif($fetch_result['q_type'] == 2)//flash
                        {
                                $count_questions += $fetch_result["good_points"];//points pour la question.
                                $query = "SELECT
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
                                
                                
                                //print_r($fetch_result_2);
                                
                                //echo "-- ".$fetch_result_2['points_max']."<br />";
                                /*
                                $fetch_result_2['points_obtenu'] = 1;
                                $fetch_result_2['points_max'] = 1 ;
                                */
                                if( $fetch_result_2['points_max'] != 0)//pour pas diviser par zéro...
                                {
                                        $count_good_question +=
                                        ( $fetch_result_2['points_obtenu']/
                                        $fetch_result_2['points_max'])*
                                        $fetch_result["good_points"];//bonne réponse.
                                }
                                
                        }
                        
                }
		if($standard)
		{
			if(!$count_questions)//if it equals 0
			{
                                return "--";
			}
			else
			{
                                
                                return $count_good_question."/".$count_questions." = ".(sprintf(__SPRINTF_SIGNIFICANTS_DIGITS_FORMAT__,$count_good_question/$count_questions*100))."%";
			}
		}
		else//return an array
		{
			if(!$count_questions)//if it equals 0
			{
                                $count_questions = 1;
			}
			/*
			
                        your_points DOUBLE UNSIGNED,
                        
                        max_points INT UNSIGNED
                        
                        */
			
			return array("your_points" => $count_good_question, "max_points" => $count_questions);
			
			
		}
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
                $stuff = score_that_you_obtained($result_id, FALSE);//return an array.
                
                //print_r($stuff);
                
                global $_OPTIONS;
                global $_RUN_TIME, $inicrond_db;//mysql
                
		$query = "UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
                SET
                your_points=".$stuff["your_points"].",
                max_points=".$stuff["max_points"]."
                
                WHERE
                result_id=".$result_id."
                ";
                
                $inicrond_db->Execute($query);
                
	}
}
?>