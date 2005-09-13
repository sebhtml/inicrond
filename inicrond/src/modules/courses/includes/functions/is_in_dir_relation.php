<?php

//$Id$

/**
* return the list
*
* @param        integer  $inode_id_mother   id to check if is the location
* @param        integer  $inode_id_to_check id of the i node.
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/	
function is_in_dir_relation($inode_id_mother, $inode_id_to_check)
{
	
	//return FALSE;
	global $_OPTIONS, $_RUN_TIME, $inicrond_db;
        
	if($inode_id_mother == $inode_id_to_check)//it's the same...
	{
                
                return TRUE;
                
	}
	
        //get the inode_id_location of the inode to check
        $query = "SELECT
	inode_id_location
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
	WHERE
	inode_id=$inode_id_to_check
	";
        
	$rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
  	
	
        if($fetch_result['inode_id_location'] == 0)
        {
		return FALSE;//it's ok!
        }	
        elseif($fetch_result['inode_id_location'] == $inode_id_mother)
        {
		return TRUE;//it is not ok.
        }
        else//recursive call.
        {
		return is_in_dir_relation($inode_id_mother, $fetch_result['inode_id_location']);
        }
}

?>