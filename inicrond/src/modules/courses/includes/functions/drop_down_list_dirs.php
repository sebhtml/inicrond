<?php

//$Id$

/**
* return the list
*
* @param        integer  $cours_id    id of a course
* @param        integer  $inode_id_location   default selection
* @param        integer  $inode_id   an inode id not to include...
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/	
function drop_down_list_dirs($cours_id, $inode_id_location, $inode_id = -1)
{
	//return ;
	global $_OPTIONS, $_RUN_TIME, $inicrond_db, $_LANG;
        $select = new Select();
        $select->set_name('inode_id_location');
        $select->set_text($_LANG['inode_id_location']);
        
        ///////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////
        $query = "SELECT
        inode_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        WHERE 
        cours_id=$cours_id
        
        AND
        content_type=0
        ";
        
        $rs = $inicrond_db->Execute($query);
        while(!$rs->EOF AND $fetch_result = $rs->FetchRow())
        
        {
                $my_option = new Option();
                
                if($fetch_result['inode_id'] == $inode_id_location)
                {
                        $my_option->selected();//SELECTED
                }
                
                $my_option->set_value($fetch_result['inode_id']);
                
                
                
                $my_option->set_text(strip_tags(inode_full_path($fetch_result['inode_id'])));
                
                
                
                if(//isset($inode_id) AND
                !is_in_dir_relation($inode_id,//the one you want to check if the other is in this one
                $fetch_result['inode_id']//the one to check
                ))
                {
                        $select->add_option($my_option);
                }
                
                
                
                
        }
        
        
        
        ///////////////////////////////////////////////////////////
        
        //add the course level (level 0)
        
        $my_option = new Option();
        
	if(0 == $inode_id_location)
	{
                $my_option->selected();//SELECTED
	}
        
        $my_option->set_value("0");
        
	$query = "SELECT
        cours_name
        
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
        WHERE 
        cours_id=$cours_id
        
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        $my_option->set_text($fetch_result['cours_name']);
        $select->add_option($my_option);
        
        $select->validate();
        
        return $select;
        
}

?>