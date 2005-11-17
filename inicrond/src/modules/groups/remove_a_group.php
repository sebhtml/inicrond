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

include 'includes/functions/remove_a_group.php' ;

include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";

if(
isset($_GET['group_id']) && 
$_GET['group_id'] != "" &&
(int) $_GET['group_id'] &&
is_chef_of_group($_SESSION['usr_id'], $_GET['group_id']) 

)
{
        
        $cours_id = group_id_to_cours_id($_GET['group_id']) ;
	$module_title =  $_LANG['remove_group'];
	
        
        
	
        if(isset($_GET["ok"]))
        {
		remove_a_group ($_GET['group_id'], $inicrond_db, $_OPTIONS) ;  
        }
        else
        {
                
		$module_content .= retournerHref("?group_id=".$_GET['group_id']."&ok",
	 	$_LANG['remove_group'])."";//enlever le group
        }
        
        //link.
        $module_content .= "<h3><a href=\"".__INICROND_INCLUDE_PATH__."modules/groups/course_groups_listing.php?&cours_id=$cours_id"."\">".$_LANG['course_groups_listing']."</a></h3>";
        
        
        
}

//INSERT CODE HERE.

include "../../includes/kernel/post_modulation.php";
?>