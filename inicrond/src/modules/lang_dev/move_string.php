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
        $module_title =  $_LANG['move_string'];
        
        if(!isset($_POST['lang_file'])
        
        )//language name.
        {
                $module_content .= "<form method=\"POST\">";
                
                ////////////////
                //the drop lisyr for strings.
                $module_content .= $_LANG['string']." : ";
                
                $module_content .= "<select name=\"id\">";
                
                $query = "SELECT
                id,
		string,
		lang_file
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
		WHERE
		language = 'en-ca' 
		ORDER BY string ASC
		";
                
		$rs = $inicrond_db->Execute($query);
                
                while($fetch_result = $rs->FetchRow())
                {
                        $module_content .= "<option  value=\"".$fetch_result["id"]."\">".$fetch_result['string']." (".$fetch_result['lang_file'].")</option>";
                        
                }
                $module_content .= "</select>";
                
                
                
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
		ORDER BY lang_file ASC
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
                
                //get the string and lang file of the id given.
                //then and only then, get all languages and foreach language, remove this string for this lang_File.
                $query = "SELECT
		string,
		lang_file
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
		WHERE
		language = 'en-ca' 
		AND
		id = ".$_POST["id"]."
		ORDER BY string ASC
		";
                
		$rs9 = $inicrond_db->Execute($query);
                $fetch_result9 = $rs9->FetchRow();
                
                
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
                        //move the string.
                        $query = "
                        UPDATE
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                        SET
                        lang_file = '".str_replace('en-ca', $fetch_result['language'], $_POST['lang_file'])."'
                        WHERE
                        string = '".$fetch_result9['string']."'
                        AND
                        lang_file = '".str_replace('en-ca', $fetch_result['language'], $fetch_result9['lang_file'])."'
                        AND
                        language = '".$fetch_result['language']."'
                        ";
                        
                        $inicrond_db->Execute($query);
                        
                }
                
        }
        
        
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>