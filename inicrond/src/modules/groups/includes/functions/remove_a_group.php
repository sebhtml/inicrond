<?php
//$Id$

function remove_a_group ($group_id, $inicrond_db, $_OPTIONS)
{




	$sql = 'select ev_id from '.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations'].' 
	where group_id = '.$group_id.' ';
	
	$results_set = $inicrond_db->Execute ($sql) ;
	
	while ($row = $results_set->FetchRow ())
	{
		$sql = 'delete from '.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores'].' where ev_id = '.$row ['ev_id'].'';
	
		$inicrond_db->Execute ($sql) ;
	}
	
	$tables_to_delete = array(
		'evaluations',
		'sections_groups_view',
		'forums_groups_reply',
		'forums_groups_start',
		'forums_groups_view',
		'sebhtml_moderators',
		'course_group_in_charge',
		'inode_groups',
		'groups_usrs',
		'groups');
                
		foreach($tables_to_delete AS $t_name)
		{	
                        $query = "DELETE FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables'][$t_name]."
                        WHERE
                        group_id=".$_GET['group_id']."
                        ";
                        
                        $inicrond_db->Execute($query);
		}





	return ;
}

?>