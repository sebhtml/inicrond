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
        $module_title =  $_LANG['compare_lang'];
        //compare with en-ca.
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
                //foreach languages, get all string forom en-ca and check if he have them.
                //then, get akll string from current language nd check if en-ca have them.
                
                $module_content .= "<h3>$language</h3>";
                
                //get all en-ca languages.
                $query = "SELECT
		string
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
		WHERE 
		language = 'en-ca'
		";
                
		$rs = $inicrond_db->Execute($query);
                
                while($fetch_result = $rs->FetchRow())
                {
                        //check if the language have it...
                        $query = "SELECT
                        string
                        FROM 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                        WHERE 
                        language = '$language'
                        AND
                        string = '".$fetch_result['string']."'
                        LIMIT 1
                        ";
                        
                        $rs2 = $inicrond_db->Execute($query);
                        
                        $fetch_result2 = $rs2->FetchRow();
                        
                        if(!isset($fetch_result2['string']))//he dont have it...
                        {
                                $module_content .= "-- ".$fetch_result['string']."<br />";//this one is missing...
                        }
                        
                }
                
                
                $query = "SELECT
		string
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
		WHERE 
		language = '$language'
		";
                
		$rs = $inicrond_db->Execute($query);
                
                while($fetch_result = $rs->FetchRow())
                {
                        //check if the en-ca have it...
                        $query = "SELECT
                        string
                        FROM 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                        WHERE 
                        language = 'en-ca'
                        AND
                        string = '".$fetch_result['string']."'
                        LIMIT 1
                        ";
                        
                        $rs2 = $inicrond_db->Execute($query);
                        
                        $fetch_result2 = $rs2->FetchRow();
                        
                        if(!isset($fetch_result2['string']))//he dont have it...
                        {
                                $module_content .= "++ ".$fetch_result['string']."<br />";//this one is missing...
                        }
                        
                }
                
        }
        
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>