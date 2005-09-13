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
        $module_title =  $_LANG['add_lang'];
        
        if(!isset($_POST['language']))//language name.
        {
                $module_content .= "<form method=\"POST\"><input type=\"text\" name=\"language\" /><input type=\"submit\" /></form>";
        }
        else
        {
                ////////////////
                //check if the language exists.
                $query = "SELECT
		string
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
		WHERE 
		language = '".$_POST['language']."'
                LIMIT 1
		";
                
		$rs = $inicrond_db->Execute($query);
                
                $fetch_result = $rs->FetchRow();
                
                if(isset($fetch_result['string']))//the language already exists.
                {
                        $module_content .= $_LANG['language_already_exists'];
                }
                else//create the language.
                {
                        
                        
                        //get all entries for en-ca
                        //for eahc entries, str replace en-ca by the new language name and the insert language  field in the new language name.
                        $query = "SELECT
                        string,
                        content,
                        lang_file
                        FROM 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                        WHERE 
                        language = 'en-ca'
                        
                        ";
                        
                        $rs = $inicrond_db->Execute($query);
                        
                        while($fetch_result = $rs->FetchRow())
                        {
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
                                '".$fetch_result['string']."',
                                '".addSlashes($fetch_result['content'])."',
                                '".str_replace('en-ca', $_POST['language'], $fetch_result['lang_file'])."',
                                '".$_POST['language']."'
                                )
                                ";
                                
                                $inicrond_db->Execute($query);
                        }
                }//end of new langaue insertion.
        }
        
        
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>