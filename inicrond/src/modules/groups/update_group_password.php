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


if(isset($_GET['group_id']) AND
$_GET['group_id'] != "" AND
(int) $_GET['group_id'] AND

is_chef_of_group($_SESSION['usr_id'], $_GET['group_id']) 

)//edit
{
        
        
        
	
        
        
        //show some informations.
        $query = "SELECT
	
        group_id,
        group_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id AS cours_id,
        cours_code,
        cours_name
        
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']." 
        WHERE 
        group_id=".$_GET['group_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        foreach($fetch_result AS $key => $value)
        {
                $module_content .= $_LANG[$key]. " : ".$value."<br />";
        }
        
        $module_content .= "<br /><br />";
        
        
        
        //die("22");
        $module_title =  $_LANG['update_group_password'];
        
        if(!isset($_POST['md5_pw_to_join']))
        {
		
                
                $module_content .=  "
                <form method=\"POST\">
                ".  $_LANG['md5_pw_to_join']." : <input type=\"password\" name=\"md5_pw_to_join\"  /> ";
                
                
                
                $module_content .="
                <input type=\"submit\"    />	
                </form>" ;  
        }
        else
        {
                
                
                $group_name = $_POST['group_name'];
                $query = "UPDATE 
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." 
                SET 
                md5_pw_to_join='".md5($_POST['md5_pw_to_join'])."'
                WHERE 
                group_id=".$_GET['group_id']."
                ";
                
                $inicrond_db->Execute($query);
                include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection	
                
                
                
                js_redir("grp.php?group_id=".$_GET['group_id']);
                
        }			
        
        
}
include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>