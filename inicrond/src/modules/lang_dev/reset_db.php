<?php

//$Id$

/*---------------------------------------------------------------------
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
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';


if($_SESSION['SUID'])
{
        $module_title =  $_LANG['reset_db'];
        
        
        if(!isset($_GET['language']))
        {
                $query = "SELECT
                DISTINCT
		language
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                
		
		";
                
		$rs5 = $inicrond_db->Execute($query);
                
                while($fetch_result5 = $rs5->FetchRow())
                {
                        $language = $fetch_result5['language'];
                        $module_content .= "<a href=\"?language=$language\">$language</a><br />";
                }
        }
        else
        {
                $language = $_GET['language'];
                
                $query = "DELETE FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
		WHERE
		language = '$language'
		";
                
                $inicrond_db->Execute($query);
                
                
                
                
        }
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>