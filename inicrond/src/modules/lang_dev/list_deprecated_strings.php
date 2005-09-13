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
        $module_title =  $_LANG['list_deprecated_strings'];
        
        //get all content of src in php files only.
        //do a big string with that oh dude it will be big...
        
        function get_all_php_content($dir)
        {
                $output = "";
                
                
                $fp = openDir($dir);
                
                while($fichier = readDir($fp))
                {
                        if(is_dir($dir.$fichier) AND
                        $fichier != ".." AND
                        $fichier != "."
                        )
                        {
                                //add the final slash
                                $output .= get_all_php_content($dir.$fichier."/");
                        }
                        elseif(
                        !strstr($dir, 'languages') AND//not in the languages path...
                        (
                        preg_match("/\.php/", $fichier) OR//is a php file? 
                        preg_match("/\.tpl/", $fichier)
                        ))
                        {
                                $fp2 = fOpen($dir.$fichier, "r");//open in read mode.
                                $output .= fRead($fp2, fileSize($dir.$fichier));
                                fclose($fp2);
                        }
                        
                }
                
                closeDir($fp);	
                
                return $output;
                
        }
        
        //recursive call to get all content...
        //only check in modules...
        $php_content = get_all_php_content(__INICROND_INCLUDE_PATH__."modules/");
        $php_content .= get_all_php_content(__INICROND_INCLUDE_PATH__."includes/");
        //echo $php_content;
	$query = "SELECT
        DISTINCT
        string
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
        ORDER by string ASC";
        
        $rs = $inicrond_db->Execute($query);
        
        
        while($fetch_result = $rs->FetchRow())
        {
                //dude this is big...
                if(!strstr($php_content, $fetch_result['string']))//this string is not found anywhere.
                {
                        //echo the unused index.
                        $module_content .= $fetch_result['string']."<br />";
                }
                
        }
        
        
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>