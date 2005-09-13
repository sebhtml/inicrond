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
        $module_title =  $_LANG['string'];
        
        if(!isset($_POST['lang_file'])
        
        )//language name.
        {
                $module_content .= "<form method=\"POST\"><input type=\"text\" name=\"string\" />";
                
                //show a drop list of lang_file
                $module_content .= $_LANG['lang_file']." : ";
                $module_content .= "<select name=\"lang_file\">";
                
                
                $query = "SELECT
                DISTINCT
		lang_file
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                
		WHERE
		language = 'en-ca'
		";
                
		$rs = $inicrond_db->Execute($query);
                
                while($fetch_result = $rs->FetchRow())
                {
                        $module_content .= "<option  value=\"".$fetch_result['lang_file']."\">".$fetch_result['lang_file']."</option>";
                }
                $module_content .= "</select>";
                
                
                $module_content .= "<input type=\"submit\" /></form>";
        }
        else
        {
                /////////////
                //check if the lang_file already exists.
                
                $query = "SELECT
                
		string
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                WHERE
                string = '".$_POST['string']."'
                LIMIT 1
		
		";
                
		$rs = $inicrond_db->Execute($query);
                
                $fetch_result = $rs->FetchRow();
                
                if(isset($fetch_result['string']))
                {
                        $module_content = $_LANG['string_already_exists'];
                }
                else
                {
                        //get all languages.
                        
                        
                        $query = "SELECT
                        DISTINCT
                        language
                        FROM 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                        
                        
                        ";
                        
                        $rs = $inicrond_db->Execute($query);
                        
                        while($fetch_result = $rs->FetchRow())
                        {
                                //foreach language.
                                $query = "INSERT INTO
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                                (
                                string,
                                content,
                                lang_file,
                                language
                                )
                                VALUES
                                (
                                '".$_POST['string']."',
                                '".$_POST['string']."',
                                '".str_replace('en-ca', $fetch_result['language'], $_POST['lang_file'])."',
                                '".$fetch_result['language']."'
                                )
                                
                                ";
                                
                                $inicrond_db->Execute($query);
                                
                        }
                }
                
        }
        
        
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>