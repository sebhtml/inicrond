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
        $module_title =  $_LANG['list_not_traducted_strings'];
        
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
                $module_content .= "<h3>$language</h3>";
                
                //get all the one that the string is the same then the ccontent and
                
                
                $query = "SELECT
		string,
		content,
		lang_file
                FROM 
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
		WHERE 
		string = content
		AND
		language = '$language'
		";
                
		$rs = $inicrond_db->Execute($query);
		$tableau = array(array($_LANG['string'], $_LANG['content'], $_LANG['lang_file']));
                while($fetch_result = $rs->FetchRow())
                {
                        if($fetch_result['string'] == $fetch_result['content'])
                        //mysql seem to say that A and a are the same
                        {
                                $tableau []= array($fetch_result['string'], $fetch_result['content'], $fetch_result['lang_file']);
                        }
                }
                
                $module_content .= $_LANG['string_and_content_are_the_same']." : <br />";
                $module_content .= retournerTableauXY($tableau);
                
                if($language != 'en-ca')
                {  
                        //get all content, string. from english one.
                        $query = "SELECT
                        string,
                        content
                        FROM 
                        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                        WHERE 
                        language = 'en-ca'
                        ";
                        
                        $rs = $inicrond_db->Execute($query);
                        $tableau = array(array($_LANG['string'], $_LANG['content'], $_LANG['lang_file']));
                        while($fetch_result = $rs->FetchRow())
                        {
                                
                                /*get all the one that string != content and that string = en-ca string and content too.
                                */
                                $query = "SELECT
                                string,
                                content,
                                lang_file
                                FROM 
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                                WHERE 
                                string = '".$fetch_result['string']."'
                                AND
                                content = '".addSlashes($fetch_result['content'])."' 
                                AND
                                string != content 
                                AND
                                language= '$language'
                                ";
                                
                                $rs2 = $inicrond_db->Execute($query);
                                while($fetch_result2 = $rs2->FetchRow())
                                {
                                        $tableau []= array($fetch_result2['string'], $fetch_result2['content'], $fetch_result2['lang_file']);
                                }
                                
                                
                                
                        }
                        $module_content .= $_LANG['the_content_is_the_same_for_en']." : <br />";
                        $module_content .= retournerTableauXY($tableau);
                        
                }//end oif if not english.
        } 
        
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>