<?php
//$Id$
/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier :
//----------------------------
// module de téléchargement
// recoit un id et permet de downloader ce fichier avec la database
//-------------------------
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond
//
//---------------------------------------------------------------------
*/
/*
inicrond
Copyright (C) 2004  Sebastien Boisvert

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
*/



define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
//include 'includes/languages/'.$_SESSION['language'].'/lang.php';



if(
isset($_GET['usr_id']) &&
$_GET['usr_id'] != "" &&
(int) $_GET['usr_id']
)
{
        
	//here I check if the person can do this 
        
	
	$query = "SELECT 
        
        usr_picture_file_name
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_id=".$_GET['usr_id']."
        
        ";
        
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        
        $file_path = $_OPTIONS["file_path"]["uploads"]."/".$fetch_result["usr_picture_file_name"];
	
	
	
        if(is_file($file_path) ) //erreur ?
        {
                
                //header("Content-Disposition: attachment; filename=img.ext");
                header("Content-Type: application/force-download");
                header("Content-Transfer-Encoding: application/octet-stream\n"); // Surtout ne pas enlever le \n
                header("Content-Length: ".filesize($file_path));
                header("Pragma: no-cache");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
                header("Expires: 0"); 		
                
                
                readfile($file_path);//cotnenu du fichier
                
                
                
        }
	
	
	
	
	
        
        
}

?>