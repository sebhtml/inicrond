<?php
/*---------------------------------------------------------------------

$Id$

sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

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
-----------------------------------------------------------------------*/
define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not 
//require lang variables.


if(
isset($_GET['group_id']) && 
$_GET['group_id'] != "" &&
(int) $_GET['group_id'] &&
is_chef_of_group($_SESSION['usr_id'], $_GET['group_id']) 

)
{
        
        $module_title = $_LANG['remove'];
	
        
        /*
        Il y a maintenant une confirmation avant la suppression d'un mebmbre 24 sept. 2004)
        
        
        */		if(isset($_GET["ok"]))//on veut vraimenet supprimer l'e membre
        {
                $query = "DELETE FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
                WHERE
                usr_id=".$_GET['usr_id']."
                AND
                group_id=".$_GET['group_id']."
                
                ";
                
                $inicrond_db->Execute($query);
		
                
        }
        else//on affiche le oui ou le nom...
        {
                
		
                $module_content .= retournerHref("?usr_id=".$_GET['usr_id'].
                "&group_id=".$_GET['group_id']."&ok", $_LANG['remove']);	
                
		
        }
        
	
        
	
	
        //link.
        $module_content .= "<h3><a href=\""."grp.php?group_id=".$_GET['group_id']."\">".$_LANG['return']."</a></h3>";
        
	
        
        
}

include "../../includes/kernel/post_modulation.php";
?>