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
        $module_title =  $_LANG['edit_strings'];
        
        ///////////////
        //show the drop lists.
        $module_content .= "<form method=\"POST\" >";
        
        //show a drop list of languages. (with selection,.)
        
        $module_content .= $_LANG['language']." : ";
        
        $module_content .= "<select name=\"language\">";
        $module_content .= "<option  value=\"\"></option>";
        $query = "SELECT
        DISTINCT
        language
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
        
        
        ";
        
        $rs = $inicrond_db->Execute($query);
        
        while($fetch_result = $rs->FetchRow())
        {
                $module_content .= "<option ".($_POST['language'] == $fetch_result['language'] ? "SELECTED" : "" )." value=\"".$fetch_result['language']."\">".$fetch_result['language']."</option>";
                
        }
        $module_content .= "</select>";
        
        
        
        //show a drop list of lang_file
        $module_content .= $_LANG['lang_file']." : ";
        $module_content .= "<select name=\"lang_file\">";
        
        $module_content .= "<option  value=\"\"></option>";
        $query = "SELECT
        DISTINCT
        lang_file
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
        
        
        ";
        
        $rs = $inicrond_db->Execute($query);
        
        while($fetch_result = $rs->FetchRow())
        {
                $module_content .= "<option ".($_POST['lang_file'] == $fetch_result['lang_file'] ? "SELECTED" : "" )." value=\"".$fetch_result['lang_file']."\">".$fetch_result['lang_file']."</option>";
        }
        $module_content .= "</select>";
        
        
        
        
        //show a field for string.
        $module_content .= $_LANG['string']." : ";
        $module_content .= "<input type=\"text\" name=\"string\" value=\"".$_POST['string']."\" />";
        
        
        
        //show a field for content .
        $module_content .= $_LANG['content']." : ";
        $module_content .= "<input type=\"text\" name=\"content\" value=\"".$_POST['content']."\" />";
        
        $module_content .= "<input type=\"submit\" name=\"search_options\" />";
        $module_content .= "</form>";
        
        
        ///////////////////////
        //update the database if there is a submission.
        if(isset($_POST["update_content"]))
        {
                foreach($_POST AS $key => $value)
                {
                        if(preg_match("/id=(.+)/", $key, $tokens)	)
                        
                        {
                                $query = "UPDATE 
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
                                SET
                                content='".($value)."'
                                WHERE
                                id=".$tokens["1"]."
                                
                                ";
                                
                                $inicrond_db->Execute($query);	
                        }//end of if.
                }
        }
        
        //query
        $query = "SELECT
        id,
        language,
        `string`,
        content,
        lang_file
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['lang_dev']."
        ";
        
        /////////////////
        //set the where clause parameters.
        if(isset($_POST["search_options"]))
        {
                $where_is_there = FALSE ;
                
                
                if($_POST['language']!= "")
                {
                        if(!$where_is_there)
                        {
                                $query .= " WHERE language  = '".$_POST['language']."'";
                                $where_is_there = TRUE;
                        }
                        else
                        {	 
                                $query .= " language  = '".$_POST['language']."' ";
                        }
                        
                }
                
                if($_POST['lang_file']!= "")
                {
                        if(!$where_is_there)
                        {
                                $query .= " WHERE  lang_file  ='".$_POST['lang_file']."'";
                                $where_is_there = TRUE;
                        }
                        else
                        {
                                $query .= " AND lang_file  ='".$_POST['lang_file']."' ";
                        }
                }
                if($_POST['string'] != "")
                {
                        if(!$where_is_there)
                        {
                                $query .= " WHERE  `string` LIKE '%".$_POST['string']."%'";
                                $where_is_there = TRUE;
                        }
                        else
                        {
                                $query .= " AND `string` LIKE '%".$_POST['string']."%' ";
                        }
                }
                if($_POST['content'] != "")
                {
                        if(!$where_is_there)
                        {
                                $query .= " WHERE content LIKE '%".$_POST['content']."%'";
                                $where_is_there = TRUE;
                        }
                        else
                        {
                                $query .= " AND content LIKE '%".$_POST['content']."%' ";
                        }
                }
        }
        
        $query .= " LIMIT 64 ";//only 64 results.
        $rs = $inicrond_db->Execute($query);
        
        $module_content .= nl2br($query);
        
        
        
        /////////////////
        //show results.
        $tableau = array(array($_LANG['string'], $_LANG['content']));
        $module_content .= "<form method=\"POST\" >";
        while($fetch_result = $rs->FetchRow())
        {
                $tableau []= array($fetch_result['string']."<br />".$fetch_result['lang_file']."<br /> ".$fetch_result['language'], "<textarea name=\"id=".$fetch_result["id"]."\">".$fetch_result['content']."</textarea>"); 
        }
        
        $module_content .= retournerTableauXY($tableau);
        
        if(isset($_POST["search_options"]))//put hidden fields.
        {
                $module_content .= "<input type=\"hidden\" name=\"string\" value=\"".$_POST['string']."\" />";
                $module_content .= "<input type=\"hidden\" name=\"lang_file\" value=\"".$_POST['lang_file']."\" />";  
                $module_content .= "<input type=\"hidden\" name=\"language\"  value=\"".$_POST['language']."\" />";  
                $module_content .= "<input type=\"hidden\" name=\"content\"  value=\"".$_POST['content']."\" />";  
                $module_content .= "<input type=\"hidden\" name=\"search_options\"   />";  
                
        }
        
        $module_content .= "<input type=\"submit\" name=\"update_content\" />";
        $module_content .= "</form>";
        
        $module_content .= "<a href=\"index.php\">".$_LANG['lang_dev']."</a><br />";
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>