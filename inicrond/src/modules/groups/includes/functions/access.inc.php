<?php

//$Id$



/**
* 
*
* @param        integer  $usr_id       
* @param        integer  $group_id     
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function is_in_charge_of_group($usr_id, $group_id)
{
        
        global $_OPTIONS, $_RUN_TIME, $inicrond_db;
        if( $_SESSION['SUID'])
        {
                return  TRUE;
        }
	if(
	!isset($usr_id) OR
	!isset($group_id)
	)
	{
                return FALSE;
	}
	
	$query33 = "SELECT 
	cours_id	 
	FROM 
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
	
	WHERE
	group_id=".$group_id."
	";
	
	$query_result33 = $inicrond_db->Execute($query33);	
	$fetch_result33 = $query_result33->FetchRow();	
        
        if(is_teacher_of_cours($usr_id,$fetch_result33['cours_id'])	)
        {
                return TRUE;
                
        }
        
	
        
        //first I get the list of course_group_id that the usrr_id is in charge
        
        $query = "
        SELECT 
        usr_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=$usr_id
        
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_id=$group_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['course_group_in_charge'].".group_in_charge_group_id= ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id
        
        ";
        
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        return isset($fetch_result['usr_id']);
        
}

?>