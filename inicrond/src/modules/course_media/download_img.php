<?php
//$Id$

/****************************************************************
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
****************************************************************/



define(__INICROND_INCLUDED__, TRUE);
define(__INICROND_INCLUDE_PATH__, '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';


include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/is_in_inode_group.php";//transfer IDs
include "includes/functions/img_id_2_inode_id.php";//transfer IDs

if(isset($_SESSION['usr_id']) && //session
is_numeric($_GET["img_id"]) AND
is_in_inode_group($_SESSION['usr_id'], img_id_2_inode_id($_GET["img_id"]))
)
{
	
	$query = "SELECT         
        img_file_name,
        img_hexa_path
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
        WHERE
        img_id=".$_GET["img_id"]."
        
        ";
        
        
        $rs = $inicrond_db->Execute($query);
        
        $fetch_result = $rs->FetchRow();
	$file_path = $_OPTIONS["file_path"]["uploads"]."/".$fetch_result["img_hexa_path"];
	
	
        if(is_file($file_path)) 
        {
                
                header("Content-Disposition: attachment; filename=".$fetch_result['img_file_name']);
                header("Content-Type: application/force-download");
                header("Content-Transfer-Encoding: application/octet-stream\n"); // Surtout ne pas enlever le \n
                header("Content-Length: ".filesize($file_path));
                header("Pragma: no-cache");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
                header("Expires: 0"); 
                
                readfile($file_path);//cotnenu du fichier
                
                $module_title = $fetch_result['img_file_name'] ;
                
                include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";
                
        }
	
	
	
	
}
else
{
	echo "access denied";
}

?>