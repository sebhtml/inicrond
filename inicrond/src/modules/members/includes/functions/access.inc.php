<?php

//$Id$



/**
* 
*
* @param        integer  $usr_id       
* @param        integer  $cours_id     
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function is_in_charge_of_user($usr_id, $asked_user_id)
{
        
        global $_OPTIONS, $inicrond_db;
	if(
	!isset($usr_id) OR
	!isset($asked_user_id)
	)
	{
                return FALSE;
	}
	if($usr_id == $asked_user_id)
	{
                return TRUE;
                
	}	
	if($_SESSION['SUID'])
	{
                return TRUE;
                
	}
	
	
        
        //lis tthe groups of the student.
        
        $query = "
        SELECT 
        t1.group_id,
        cours_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." AS t1,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']." AS t2
        WHERE
        usr_id=$asked_user_id
        AND
        t1.group_id=t2.group_id
        
        ";
        
        
        
        
        $rs = $inicrond_db->Execute($query);
        
        //dforeach group, check if the teacher is teacher dand/or in charge.
        while($fetch_result = $rs->FetchRow())
        {
                
                
                //foreach group the user is in, check if the other usr is teacher in this group.
                
                if(is_teacher_of_cours($_SESSION['usr_id'], $fetch_result['cours_id']))//is he a teacher.
                {
                        return TRUE ;
                        
                }
                
                //else check if he is in charge.
                $query = "
                SELECT 
                usr_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge']."
                WHERE
                
                usr_id=$usr_id
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_id=".$fetch_result['group_id']."
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_in_charge_group_id
                
                ";
                
                
                
                $rs2 = $inicrond_db->Execute($query);
                $fetch_result = $rs2->FetchRow();
                
                if(isset($fetch_result['usr_id']))
                {
                        return TRUE ;
                        
                }
        }
        
        
        return FALSE;
}

?>