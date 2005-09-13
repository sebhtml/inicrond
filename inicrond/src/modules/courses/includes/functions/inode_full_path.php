<?php

//$Id$

/**
* return the inode path
*
* @param        integer  $inode_id    id of an inode
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/	
function inode_full_path($inode_id, $cours_id = NULL)
{
	global $_OPTIONS, /*$_RUN_TIME, */$inicrond_db;
        $full_path = "";
        
        if($inode_id == 0)//at the root dude.
        {
                //return the cours name
                $query = "SELECT
                cours_name
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
                WHERE
                cours_id=$cours_id
                ";
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
                return "<a href=\"inode.php?cours_id=$cours_id\">".$fetch_result['cours_name']."</a>";
        }
        else
        {
                //get the name to add
                
                //echo "I get the name of inode #$inode_id<br /";
                // get the file_name, media_name or test_name.
                /*
                # 0 : dir
                # 1 : file
                # 2 : test
                # 3 : media.
                */
                $query = "SELECT
                dir_name,
                inode_id_location,
                content_type,
                content_id,
                inode_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']." AS T1,
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['virtual_directories']." AS T2
                
                WHERE
                inode_id=".$inode_id."
                AND
                T1.content_id = T2.dir_id
                ";
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                $NAME=	$fetch_result["dir_name"];
                
                //get the content_name.
                
                if($fetch_result["content_type"])// != 0, is not a directory.
                { 
                        switch($fetch_result["content_type"])
                        {
                                case 0 :
                                //the query have already been done... --sebhtml
                                
                                break;
                                
                                case 1 :// file
                                $query = "SELECT
                                file_title AS NAME
                                FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
                                WHERE
                                file_id=".$fetch_result["content_id"]."
                                ";
                                
                                break;
                                case 2 ://test
                                $query = "SELECT
                                test_name AS NAME
                                FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
                                WHERE
                                test_id=".$fetch_result["content_id"]."
                                ";
                                
                                break;
                                case 3 ://swf
                                $query = "SELECT
                                chapitre_media_title AS NAME
                                FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['chapitre_media']."
                                WHERE
                                chapitre_media_id=".$fetch_result["content_id"]."
                                ";
                                
                                break;
                                case 4 ://image
                                $query = "SELECT
                                img_title AS NAME
                                FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
                                WHERE
                                img_id=".$fetch_result["content_id"]."
                                ";
                                
                                break;
                                case 5 ://text
                                $query = "SELECT
                                text_title
                                AS NAME
                                FROM
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts']."
                                WHERE
                                text_id=".$fetch_result["content_id"]."
                                ";
                                
                                break;
                                default :///
                                
                                break;
                                
                                
                        }
                        $rs2 = $inicrond_db->Execute($query);
                        $fetch_result2 = $rs2->FetchRow();
                        $NAME=	$fetch_result2["NAME"];	
                }
                
		
                if(!$fetch_result["content_type"])//is a directory, show the link...
                {
                        
                        $full_path = "<a href=\"../../modules/courses/inode.php?&inode_id_location=".$fetch_result['inode_id']."\">".$NAME."</a>";
                        
                        
                }
                else//is not a directory, dont show the link.
                {
                        //$_RUN_TIME["first_child"] = TRUE ;
                        $full_path = "".$NAME."";
                }
                
		if($fetch_result['inode_id_location'] == 0 )//bang the root...
		{//return the full path with the course name.
                        //get the course id
                        $query = "SELECT
                        cours_name,
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id
                        FROM
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
			".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
                        WHERE
                        inode_id=".$inode_id."
                        AND
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id
                        ";
                        
                        $rs = $inicrond_db->Execute($query);
                        $fetch_result = $rs->FetchRow();
                        
			
                        //echo "I add the course name and return it<br />";
			
                        
                        
                        
                        return "<a href=\"../../modules/courses/inode.php?&cours_id=".$fetch_result['cours_id']."\">".$fetch_result['cours_name']."</a>"." &gt;&gt; ".$full_path;//pas d'erreur
		}//end of final function return.
		else///Recursive call.
		{
                        
                        //recursive call.
                        //echo "Recursive call<br />";
                        return inode_full_path($fetch_result['inode_id_location'])." &gt;&gt; ".$full_path;
                        
		}//end of recursivve call block.
	}//end of else for not equal to 0.	
}//end of function.

?>