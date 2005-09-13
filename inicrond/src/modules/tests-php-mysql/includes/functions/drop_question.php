<?php

function drop_question($question_id)
{
        global $_OPTIONS, $inicrond_db;
        $query = 
	"DELETE FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['answers']."
	WHERE
	question_id=".$question_id."";
        
        
        $inicrond_db->Execute($query);
	
        $query = 
	"DELETE FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['multiple_short_answers']."
	WHERE
	question_id=".$question_id."";
        
        
        $inicrond_db->Execute($query);
        
        $query = 
	"DELETE FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['questions']."
	WHERE
	question_id=".$question_id."";
        
        
        $inicrond_db->Execute($query);
        
}

?>