<?php
/**
* find if a usr is the leader of a group
*
* @param        integer  $usr_id       
* @param        integer  $answer_id     
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
* @return bool
*/
function check_answer_granted($usr_id, $answer_id)
{
        global  $granted_answers;
        
	if(isset($granted_answers[$answer_id]) 
	
	)//already granted.
	{
                
                return $granted_answers[$answer_id];
	}
        
        global $_OPTIONS, $_RUN_TIME, $inicrond_db;
        
        
        $query = "
        SELECT
        question_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
        WHERE
        answer_id=$answer_id
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        $ans = check_question_granted($usr_id, $fetch_result["question_id"]);
        
        $granted_answers[$answer_id] = $ans;
        
	return $ans;
}

?>