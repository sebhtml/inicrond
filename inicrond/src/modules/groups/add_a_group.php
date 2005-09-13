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
//-------------------
// liste de liens
//--------------------
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';





if(isset($_GET['cours_id']) AND
$_GET['cours_id'] != "" AND
(int) $_GET['cours_id'] AND
is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id'])
)//check if the get is ok to understand.
{
        
	
        $module_title =  $_LANG['add_a_group'] ;
        
        if(!isset($_POST["envoi"]))
        {
		
		$fetch_result['default_pending'] = 1 ;
		
                $module_content .=  "
                <form method=\"POST\">
                ".  $_LANG['group_name']." : <input type=\"text\" name=\"group_name\"  /> 
                ";   
                
                
                $module_content .="
                <input type=\"submit\" name=\"envoi\"   />	
                </form>" ;  
        }
        else
        {
                
                $_POST['md5_pw_to_join'] = md5($_POST['md5_pw_to_join']);
                
                
                $query = "INSERT INTO
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." 
                (group_name, cours_id, default_pending, md5_pw_to_join)
                VALUES
                ('".$_POST['group_name']."',
                ".$_GET['cours_id'].",
                '1',
                '".md5('')."' )
                ;";
                
                $inicrond_db->Execute($query);
                
                
                
		include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection				
                js_redir("course_groups_listing.php?cours_id=".$_GET['cours_id']);
                
                
                
                
                
        }
        
        
}
include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>