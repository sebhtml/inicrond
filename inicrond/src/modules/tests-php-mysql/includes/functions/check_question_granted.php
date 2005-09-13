<?php

/**
* find if a usr is the leader of a group
*
* @param        integer  $usr_id       
* @param        integer  $question_id     
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
* @return bool
*/
function check_question_granted($usr_id, $question_id)
{
        global  $granted_questions, $inicrond_db;
        
	if(isset($granted_questions[$question_id]) 
	// == true
	)//already granted. or denied
	{
                
                return $granted_questions[$question_id] ;
	}
        
        global $_OPTIONS, $_RUN_TIME;
        
	if($_SESSION['SUID'])//super user
	{
                
                return TRUE;
	}
        
        $query = "
        SELECT
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id AS GRANTED
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']["groups"].".cours_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']["groups"].".group_id
        AND
        is_teacher_group = '1'
        AND
        question_id=$question_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=$usr_id
        ";
        
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        $ans = isset($fetch_result["GRANTED"]) ;
        
        $granted_questions[$question_id] = $ans;
        
	return $ans;
}
?>