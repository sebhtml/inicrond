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
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include __INICROND_INCLUDE_PATH__."modules/marks/includes/languages/".$_SESSION['language'].'/lang.php';
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

) 
AND

is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id'])

)
//ajouter
{
	include __INICROND_INCLUDE_PATH__."modules/courses/includes/functions/inode_full_path.php";	
        $module_content .= inode_full_path($_GET['inode_id_location'], $_GET['cours_id']);
        
        $module_title =  $_LANG['add'];
        
        
	
        
        
        
        
        if(!isset($_POST['text_title']))
        {
                $smarty->assign("_LANG", $_LANG);
                
                $module_content .= $smarty->fetch($_OPTIONS['theme']."/text_form.tpl");
		
                
                
        }
        else // il y a eu envoi de données
        {
                
                
                if($_POST['text_title'] == "")
                {
			$module_content .=  $_LANG['empty_string'];
                        //	echo "1";
                }
                
                else
                {
                        
                        
                        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";
			
                        
			$time_t = inicrond_mktime();
                        
                        
                        
			$query = "
			INSERT INTO 
			".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_texts']."
			(
			text_title,
			text_description,
			edit_time_t,
			add_time_t,
			cours_id			
			) 
			VALUES 
			(
			'".filter($_POST['text_title'])."',
			'".filter($_POST['text_description'])."',
			$time_t,
			$time_t,
			".$_GET['cours_id']."
			)
			";
                        
			$inicrond_db->Execute($query);
			$text_id = $inicrond_db->Insert_ID();
                        
                        
                        
                        
                        
                        
                        
                        
                        //insert the inode link...
                        $query = "INSERT INTO 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                        (inode_id_location, content_type, content_id, cours_id)
                        VALUES
                        (".$_GET['inode_id_location'].", '5', ".$text_id.", ".$_GET['cours_id'].")
                        " ;
                        
                        $inicrond_db->Execute($query);
                        
                        $order_id=$inicrond_db->Insert_ID();
                        
                        $query = "UPDATE
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements']."
                        SET
                        order_id=$order_id
                        WHERE
                        inode_id=$order_id
                        " ;
                        $inicrond_db->Execute($query);
                        
                        include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";
                        
                        js_redir(__INICROND_INCLUDE_PATH__."modules/courses/inode.php?inode_id_location=".$_GET['inode_id_location']."&cours_id=".$_GET['cours_id']);
                        
                        
                }
        }
	
        
	
}



include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php'; 

?>
