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

include __INICROND_INCLUDE_PATH__."modules/groups/includes/functions/group_id_to_cours_id.php";//init inicrond kernel
include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';

if(//list all groups for a course.
isset($_GET['group_id']) AND
$_GET['group_id'] != "" AND
(int) $_GET['group_id'] AND
is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id'])//is in charge of the group???.
)
{
        
        $module_title .= $_LANG['evaluations_graphics_for_a_group'];
        
        
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
        
        
        //get all evaluations to get image links.
        
        $query = "SELECT 
        ev_id,
        ev_name,
        comments
        
        
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." 
        
        WHERE
        group_id=".$_GET['group_id']."
        AND
        available = '1'
        ORDER BY order_id ASC
        ";
	$rs = $inicrond_db->Execute($query);
	
	while($fetch_result = $rs->FetchRow())
        {
                $module_content .= $fetch_result['ev_name']." (#".$fetch_result['ev_id'].")<br />".nl2br($fetch_result['comments'])."<br /><img src=\"blue_master_graphic.php?ev_id=".$fetch_result['ev_id']."\" /><br />";
                ;
                
                
        }
        
        $module_content .= $_LANG['final_mark']."<br /><img src=\"blue_master_graphic.php?group_id=".$_GET['group_id']."\" /><br />";
        ;
        
}

//INSERT CODE HERE.

include "../../includes/kernel/post_modulation.php";
?>