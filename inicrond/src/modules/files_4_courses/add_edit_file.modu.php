<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

//
//---------------------------------------------------------------------
*/


define(__INICROND_INCLUDED__, TRUE);
define(__INICROND_INCLUDE_PATH__, '../../');

include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

/////end of title 
include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/inode_full_path.php";
include __INICROND_INCLUDE_PATH__."modules/files_4_courses/includes/functions/file_id_2_inode_id.php";//transfer IDs
include "includes/functions/conversion.function.php";//transfer IDs

include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/transfert_cours.function.php";//transfer IDs

if(

isset($_GET['cours_id']) AND
$_GET['cours_id'] != "" AND
(int) $_GET['cours_id'] AND

isset($_GET['inode_id_location']) AND
$_GET['inode_id_location'] != "" AND
//(int) $_GET['inode_id_location'] AND

(
inode_to_course($_GET['inode_id_location']) == $_GET['cours_id']
OR
$_GET['inode_id_location'] == 0

) AND





//teacher

is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id'])



)//add a file
{
        
        
        //get the title of the page.
        
	//title
	$query = "SELECT
        cours_name,
        cours_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
        WHERE 
        cours_id=".$_GET['cours_id']."
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        $module_title =  $_LANG['add'];
        
        /////end of title 
        
	if(!isset($_POST["okidou"]))//show the form
	{
                //$module_content .= inode_full_path(($_GET['file_id']));
                include "includes/forms/file.form.php";
	}
	/*elseif(1)//DEBUG
	{
                echo "preg_match(\"".$_OPTIONS['preg_file_name']."\", \"".$_FILES['uploaded_file']['name']."\") ==". preg_match($_OPTIONS['preg_file_name'], $_FILES['uploaded_file']['name'])."";
                
                exit();
	}*/
	elseif(!preg_match($_OPTIONS['preg_file_name'], $_FILES['uploaded_file']['name']))
	{
                $module_content .= $_LANG['incorrect_file_name'];
                
	}
	else//update and redirect.
	{//beginning of the insert new file
                
                
                $add_gmt = $edit_gmt = inicrond_mktime();
		include __INICROND_INCLUDE_PATH__."includes/functions/hex.function.php";
                $md5_path = hex_gen_32();//hexadecimal string
                
                $filesize = filesize($_FILES['uploaded_file']['tmp_name']);
                
                
                
                include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";
                $query = "
                INSERT INTO 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
                (
                file_name,
                file_infos,
                
                file_title,
                md5_sum,
                md5_path,
                
                add_gmt,
                edit_gmt,
                filesize
                ) 
                VALUES 
                (
                
                '".($_FILES['uploaded_file']['name'])."',
                '".filter($_POST["file_infos"])."',
                
                '".filter($_POST['file_title'])."',
                '".md5_file($_FILES['uploaded_file']['tmp_name'])."',
                '".$md5_path."',
                
                ".$add_gmt.",
                ".$edit_gmt.",
                $filesize
                )
                ;";
                
                $inicrond_db->Execute($query);
		
                $file_id = $inicrond_db->Insert_ID();
                
                //insert the inode link...
                $query = "INSERT INTO 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                (inode_id_location, content_type, content_id, cours_id)
                VALUES
                (".$_GET['inode_id_location'].", 1, ".$file_id.", ".$_GET['cours_id'].")";
                
                $inicrond_db->Execute($query);
                ;
                $order_id= $inicrond_db->Insert_ID();
                
                $inicrond_db->Execute("UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                SET
                order_id=$order_id
                WHERE
                inode_id=$order_id
                ");
                
                
		if(!copy($_FILES['uploaded_file']['tmp_name'], $_OPTIONS["file_path"]["uploads"]."/".$md5_path))
                {
			die($_LANG['error_file']);
                }
                
                include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
                
                js_redir(__INICROND_INCLUDE_PATH__."modules/courses/inode.php?inode_id_location=".$_GET['inode_id_location']."&cours_id=".$_GET['cours_id']);
                
                
	}//end of the insert new file
        
        
        
}
elseif(

isset($_GET['file_id']) AND
$_GET['file_id'] != "" AND
(int) $_GET['file_id'] AND


is_teacher_of_cours($_SESSION['usr_id'],file_2_cours($_GET['file_id']))

)//add a file//edit a file
{
        
        //get the title of the page.
        
	//title
	$query = "SELECT
        file_name,
        cours_name,
        
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".cours_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
        
        WHERE 
         ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = '1'
         and
          ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id =  ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id
          and
        file_id=".$_GET['file_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id
        
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        
        
        $module_title =  $_LANG['edit'];
        
        /////end of title 
        
        $query = "SELECT
        cours_name,
        
        
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".cours_id,
        file_title,
        file_infos,
        md5_path
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
        
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
        WHERE 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_type = '1'
        and
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id = ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files'].".file_id 
        and
        file_id=".$_GET['file_id']."
        
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        
        $md5_path = $fetch_result["md5_path"];//for later
        
	if(!isset($_POST["okidou"]))//show the form
	{
                
                
                
                include __INICROND_INCLUDE_PATH__."modules/courses/includes/languages/".$_SESSION['language'].'/lang.php';
                
                $module_content .= inode_full_path (file_id_2_inode_id($_GET['file_id']));
                include "includes/forms/file.form.php";
	}
	elseif(is_file($_FILES['uploaded_file']['tmp_name']) AND
	!preg_match($_OPTIONS['preg_file_name'], $_FILES['uploaded_file']['name']))
	{
                $module_content .= $_LANG['incorrect_file_name']."<br />";
                $module_content .= $_OPTIONS['preg_file_name'].", ".$_FILES['uploaded_file']['name'];
	}
	else//update and redirect.
	{//beginning of the insert new file
                

                include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";
                $query = "
                UPDATE
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
                SET
                file_infos='".filter($_POST["file_infos"])."',
                file_title='".filter($_POST['file_title'])."',
                
                edit_gmt=".inicrond_mktime()."
		WHERE
                file_id=".$_GET['file_id']."
                ";
                
                $inicrond_db->Execute($query);
		
                if(is_file($_FILES['uploaded_file']['tmp_name']))
                {
                        
                        
                        $filesize = filesize($_FILES['uploaded_file']['tmp_name']);
			
			
                        
                        if(!copy($_FILES['uploaded_file']['tmp_name'], $_OPTIONS["file_path"]["uploads"]."/".$md5_path))
			{
                                die($_LANG['error_file']);
			}
			//update the file infos...
			$query = "
			UPDATE
			".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['courses_files']."
			SET
			file_name='".filter($_FILES['uploaded_file']['name'])."',
			md5_sum='".md5_file($_FILES['uploaded_file']['tmp_name'])."',
			filesize=$filesize
			WHERE
			file_id=".$_GET['file_id']."
			";
                        
                        $inicrond_db->Execute($query);
			
			
			
                }
                
                
                
                
                $query = "SELECT
                inode_id_location,
                cours_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                WHERE 
                content_id=".$_GET['file_id']."
                
                AND
                content_type= '1'
                ";
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
                include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection	
                
                js_redir(__INICROND_INCLUDE_PATH__."modules/courses/inode.php?inode_id_location=".$fetch_result['inode_id_location']."&cours_id=".$fetch_result['cours_id']);
                
	}//end of the insert new file
        
        
        
        
}//end of edit.



include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';




?>