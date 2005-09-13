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
        $module_title =  $_LANG['populate_db'];
        
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
        
        
        
        
        if(!isset($_GET['language']))
        {
                foreach($_OPTIONS['languages'] AS $language)
                {
                        $module_content .= "<a href=\"?language=$language\">$language</a><br />";
                }
        }
        else
        {
                $language = $_GET['language'];
                
                $module_content .= "<h3>".$language."</h3>";
                
                
                
                //get all language s files foreach languages. without the include prefix.
                //core level.
                $lang_dirs = array();
                
                $lang_dirs []= "includes/languages/$language/";
                
                //get all modules.
                $modules_path = "modules/";
                $fp = openDir(__INICROND_INCLUDE_PATH__.$modules_path);
                while($module_name = readDir($fp))
                {
                        if(is_dir(__INICROND_INCLUDE_PATH__.$modules_path."$module_name/includes/languages/$language/") AND
                        $module_name != "..")
                        {
                                //add the language path.
                                $lang_dirs []=$modules_path."$module_name/includes/languages/$language/";//without include prefix
                        }
                }
                
                foreach($lang_dirs AS $lang_dir) 
                {
                        
                        //get all .php files in the place.
                        $fp = openDir(__INICROND_INCLUDE_PATH__.$lang_dir);
                        
                        while($possible_lang_file = readDir($fp))
                        {
                                if(is_file(__INICROND_INCLUDE_PATH__.$lang_dir."$possible_lang_file") AND
                                //it ends with .php
                                preg_match("/\.php$/", $possible_lang_file)
                                )
                                {
                                        $_LANG = array();//reset the variable.
                                        include __INICROND_INCLUDE_PATH__.$lang_dir.$possible_lang_file;//include the lang file.
                                        $lang_file = $lang_dir."$possible_lang_file";
                                        
                                        
                                        
                                        
                                        foreach($_LANG AS $string => $content)//foreach index.
                                        {
                                                $tmp_lang = $_LANG;
                                                include 'includes/languages/'.$_SESSION['language'].'/lang.php';
                                                $module_content .= "<b>$string</b> ";
                                                
                                                
                                                $query = "SELECT
                                                
                                                language,
                                                string,
                                                content,
                                                lang_file
                                                
                                                
                                                FROM 
                                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                                                WHERE 
                                                language = '$language'
                                                AND
                                                string = '$string'
                                                
                                                AND
                                                lang_file = '$lang_file'
                                                ";
                                                
                                                $rs = $inicrond_db->Execute($query);
                                                $fetch_result = $rs->FetchRow();
                                                
                                                if(!isset($fetch_result['string']))//it does not exists : insert the line.
                                                {
                                                        $query = "INSERT INTO
                                                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                                                        (
                                                        language,
                                                        string,
                                                        content,
                                                        lang_file
                                                        )	 
                                                        
                                                        VALUES
                                                        (
                                                        '$language',
                                                        '$string',
                                                        '".addSlashes($content)."',
                                                        '$lang_file'
                                                        )
                                                        ";
                                                        
                                                        $inicrond_db->Execute($query);
                                                        
                                                        $module_content .= "<span class=\"keyword\">".$_LANG['the_string_have_been_inserted']."</span>";
                                                        
                                                }
                                                else//it exists, check if it is the same...
                                                {
                                                        if($fetch_result['content'] != $content)//the content is different.
                                                        {
                                                                $module_content .= "<span class=\"keyword\">".sprintf($_LANG['the_string_is_different'], $string, $lang_file, $language, $content, $fetch_result['content'])."</span>";
                                                        }
                                                        else
                                                        {
                                                                $module_content .= $_LANG['already_in_database_and_the_same'];
                                                        }
                                                }
                                                
                                                $module_content .= "<br />";
                                                $_LANG = $tmp_lang;
                                        }
                                }
                                
                        }
                        
                        
                        
                }//end of foreach lang dir.
                //foreach language,
                //reset $_LANG, then includes all lang file for the language.
                
                
                
                //foreach index of lang,
                //check if the entry already exists.
                //if not, insert in db.
                //if it exists and the content is different, echo a message, but dont update the thing.
                
                
                
                
        }
        
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>