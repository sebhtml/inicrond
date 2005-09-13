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
        $module_title =  $_LANG['check_double_content'];
        
	$query = "SELECT
        DISTINCT
        language
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
        
        
        ";
        
        $rs2 = $inicrond_db->Execute($query);
        
        while($fetch_result2 = $rs2->FetchRow())
        {
                $language = $fetch_result2['language'];
                $module_content .= "<h3>$language</h3>";
                //select all entries that have a double string group by language.
                $query = "SELECT
		COUNT(content),
		string,
		content,
		lang_file
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
		WHERE 
		
		language = '$language'
		GROUP BY content
		";
                
		$rs = $inicrond_db->Execute($query);
		$tableau = array(array("", $_LANG['content'], $_LANG['lang_file']));
                while($fetch_result = $rs->FetchRow())
                {
                        if($fetch_result["COUNT(content)"] > 1)
                        {
                                //isf this is there, list all lang_file
                                $query = "SELECT
                                lang_file,
                                string
                                FROM 
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                                WHERE 
                                
                                content = '".$fetch_result['content']."'
                                AND
                                language = '$language'
                                ";
                                
                                $rs5 = $inicrond_db->Execute($query);
                                $lang_files = "";
                                while($fetch_result5 = $rs5->FetchRow())
                                {
                                        $lang_files .= $fetch_result5['lang_file']."&nbsp;<b>".$fetch_result5['string']."</b><br />";
                                }
                                $tableau []= array($fetch_result["COUNT(content)"], $fetch_result['content'], $lang_files);
                        }
                }
                
                $module_content .= retournerTableauXY($tableau);
        } 
        
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>