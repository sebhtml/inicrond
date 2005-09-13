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

if(//list all groups for a course.
isset($_GET['cours_id']) AND
$_GET['cours_id'] != "" AND
(int) $_GET['cours_id'] AND
is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id'])//a teacher only can see this very page.
)
{
        $module_content = "";
        $course_infos =  get_cours_infos($_GET['cours_id'] );
        
        $module_content .= retournerTableauXY($course_infos)."<br />";
        
        $module_title = $_LANG['list_evaluations'];
        
        //list all group, foreach group, list the evaluation and can add one if you wish...
        
        $query = "SELECT 
        group_id,
        group_name
        
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." 
        
        WHERE
        cours_id=".$_GET['cours_id']."
        
        
        ";
	$rs = $inicrond_db->Execute($query);
	while($fetch_result = $rs->FetchRow())
	{
                //output the group number and name.
                $module_content .= "<a href=\"view_evaluations_with_a_group.php?group_id=".$fetch_result['group_id']."\">".$fetch_result['group_name']."</a>  <br />";	
                
                ////////////////////
                //the link to add a stuff.
                
                
                
                
	}
        
	//return to the home.
	
        $module_content .= "<h2><a href=\"blue_master_clone.php?cours_id=".$_GET['cours_id']."\">".$_LANG['return']."</a></h2>";	
        
        
}

//INSERT CODE HERE.

include "../../includes/kernel/post_modulation.php";
?>