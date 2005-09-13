<?php

/**
* find if a usr is the leader of a group
*
* @param        integer  $usr_id       
* @param        integer  $short_answer_id     
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
* @return bool
*/
function check_short_answer_granted($usr_id, $short_answer_id)
{
        global  $granted_short_answers, $inicrond_db;
        
	if(isset($granted_short_answers[$short_answer_id]) 
	
	)//already granted.
	{
                
                return $granted_short_answers[$short_answer_id];
	}
        
        global $_OPTIONS, $_RUN_TIME;
        
        
        $query = "
        SELECT
        question_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
        WHERE
        short_answer_id=$short_answer_id
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        $ans = check_question_granted($usr_id, $fetch_result["question_id"]);
        
        $granted_short_answers[$short_answer_id] = $ans;
        
	return $ans;
}


?>