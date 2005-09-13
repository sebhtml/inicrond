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
        $module_title =  $_LANG['write_lang_files'];
        
        
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
                
                $query = "SELECT DISTINCT
                lang_file
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
		WHERE
		language = '$language'		 
		
		";
                
		$rs = $inicrond_db->Execute($query);
                
		function create_all_parent_directories($root, $path)
		{
                        //first break it apart.
                        // ../../../../
                        // includes/languages/fr-ca
                        //becomes
                        /*
                        
                        includes
                        languages
                        fr-ca
                        */
                        
                        $directories = explode("/", $path);
                        $path = $root;
                        foreach($directories AS $directory)
                        {
                                if(!is_dir($path.$directory))
                                {
                                        mkdir($path.$directory);
                                }
                                
                                $path = $path.$directory."/";
		//}
                        }
                        return TRUE;
		}
		
                while($fetch_result = $rs->FetchRow())//foreach langfile.
                {
                        //get all string.
                        $query = "SELECT 
                        string,
                        content,
                        language,
                        lang_file
                        FROM 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                        WHERE
                        lang_file = '".$fetch_result['lang_file']."'		 
                        ORDER BY string
                        ";
                        
                        $rs2 = $inicrond_db->Execute($query);
                        $output = "<?php
                        
                        // lang_file : ".$fetch_result['lang_file']."
                        // language : $language
                        // ".date("r")."
                        
                        ";
                        while($fetch_result2 = $rs2->FetchRow())//foreach langfile.
                        {
                                
                                $output .= '$_LANG[\''.$fetch_result2['string'].'\'] = \''.str_replace('\'', '\\\'', $fetch_result2['content']).'\';
                                ';  
                        }
                        
                        $output .= "
                        ?>";
                        
                        $prefix = __INICROND_INCLUDE_PATH__ ;
                        create_all_parent_directories($prefix, dirname($fetch_result['lang_file'].""));
                        
                        USER_file_put_contents($prefix.$fetch_result['lang_file']."", $output);
                        
                }
                
                
        }
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>