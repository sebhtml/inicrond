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

define(__INICROND_INCLUDED__, TRUE);
define(__INICROND_INCLUDE_PATH__, '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

if(isset($_GET['cours_id']) AND
$_GET['cours_id'] != "" AND
(int) $_GET['cours_id'] AND
is_teacher_of_cours($_SESSION['usr_id'], $_GET['cours_id'])
)//check if the get is ok to understand.
{
        
        $module_title = $_LANG['list_images'];
        
        include __INICROND_INCLUDE_PATH__.'modules/courses/includes/functions/inode_full_path.php';
        
        
        
        $query = "SELECT
        
	img_file_name AS NAME,
        inode_id_location
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].",
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".cours_id=".$_GET['cours_id']."
	
	AND
	content_type='4'
	AND
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inode_elements'].".content_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['inicrond_images'].".img_id
	
	
	ORDER BY NAME ASC";
        
        
        $results = array(array($_LANG['title'], $_LANG['inode_id_location']));
        
        $rs = $inicrond_db->Execute($query);
	while($fetch_result = $rs->FetchRow())
	{
                $results []= array(
                $fetch_result["NAME"],
                inode_full_path($fetch_result['inode_id_location'], $_GET['cours_id']));
	}
	
        $module_content .= retournerTableauXY($results);
	
	
        $module_content .= "<h3><a href=\"course_admin_menu.php?cours_id=".$_GET['cours_id']."\">".$_LANG['course_admin_menu']."</a></h3>";
        
}//end of is_teacher

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>