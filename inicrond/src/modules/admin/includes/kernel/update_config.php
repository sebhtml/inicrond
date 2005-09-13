<?php
//$Id$


//-----------------------------------
/*
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

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

//
//---------------------------------------------------------------------
*/

if(__INICROND_INCLUDED__)
{
        
        $_OPTIONS['tables'] = array();
        
        $fp = openDir(__INICROND_INCLUDE_PATH__."modules/");
        while($mod_name = readDir($fp))//foreach module.
        {
                $tables_file = __INICROND_INCLUDE_PATH__."modules/$mod_name/includes/install_conf/tables.php";
                
                //echo $tables_file;
                if(is_dir(__INICROND_INCLUDE_PATH__."modules/$mod_name") AND
                is_file($tables_file))//if the file exists
                {
                        include $tables_file;//get the table names.
                        
                }
        }
        
        
        //
        //GET all tables names.
        //
        
        $output = "";
        
	foreach($_OPTIONS['tables'] AS  $value)
	{
                $output .= "\$_OPTIONS['tables']['$value'] = '$value';
                ";	
	}
        
        USER_file_put_contents(__INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["sql_tables"], "<?php\n$output?>");
	
        $module_content .=  "<table border=\"0\"  cellpadding=\"5\" bgcolor=\"#FAAEDD\" width=\"100%\"><tr><td>";
        $module_content .=  sprintf( $_LANG['file_has_been_Written'], $_OPTIONS["file_path"]["sql_tables"]);
        $module_content .=  "</td></tr></table>";
        
        
        ////////////////////
        //get all the languages.
        $possible_language = array();
        
        $fp = openDir(__INICROND_INCLUDE_PATH__."includes/languages");
        while($language = readDir($fp))
        {
                if(is_dir('includes/languages'."/".$language) AND
                is_file("includes/languages"."/".$language.'/lang.php'))
                {
                        $possible_language[]= $language; 
                }
                
        }
        closeDir($fp);
        
        
        
        $content = "";
        
        foreach($possible_language AS $language)
        {
                
                $content .= "\$_OPTIONS['languages']['$language'] = '$language';\n";
                
                
        }
        
        USER_file_put_contents(__INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["available_langs.php"], "<?php\n$content?>");
        
        
        $module_content .=  "<table border=\"0\"  cellpadding=\"5\" bgcolor=\"#ABFEDD\" width=\"100%\"><tr><td>";
        $module_content  .=  sprintf( $_LANG['file_has_been_Written'], $_OPTIONS["file_path"]["available_langs.php"]);
        $module_content .=  "</td></tr></table>";
        
        
        ////////////////////
        //get all templates set.
        $themes = array();
        
        $fp = openDir(__INICROND_INCLUDE_PATH__."templates/");
        while($theme = readDir($fp))
        {
                if(is_dir(__INICROND_INCLUDE_PATH__."templates/$theme") AND
                $theme != ".." AND 
                $theme != "." AND
                $theme != "CVS"
                )
                {
                        $themes[]= $theme; 
                }
                
        }
        closeDir($fp);
        
        
        
        $content = "";
        
        foreach($themes AS $theme)
        {
                
                $content .= "\$_OPTIONS['themes']['$theme'] = '$theme';\n";
                
                
        }
        //write the file down...
        USER_file_put_contents(__INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["themes.php"], "<?php\n$content?>");
        
        
        $module_content .=  "<table border=\"0\"  cellpadding=\"5\" bgcolor=\"#ABFEDD\" width=\"100%\"><tr><td>";
        $module_content  .=  sprintf( $_LANG['file_has_been_Written'], $_OPTIONS["file_path"]["themes.php"]);
        $module_content .=  "</td></tr></table>";
        
        
        
}


?>
