<?php
/*
    $Id: smarty_cache_config.php 79 2005-12-21 14:37:07Z sebhtml $

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005  Sébastien Boisvert

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include "includes/functions/generate_time_drop_list.php";

if($_SESSION['SUID'])
{
        $module_content .= "<h2><a href=\"admin_menu.php\">".$_LANG['admin']."</a></h2>";
        $module_title =  $_LANG['smarty_cache_config'];
        unlink($_OPTIONS["file_path"]['smarty_cache_config']);//destroy the config ffile.
        if(isset($_POST["data_is_sent"]))//update the results
        {
                /////////
                //here I update the results
                foreach($_POST AS $key => $value)//pour chaque donn�ss.
                {		
                        $key = preg_replace("/_tpl&/",".tpl&", $key);//qto correct a little bogus.
                        
                        if(preg_match("/&mod_dir=(.+)&tpl_file=(.+)&/", $key, $tokens))
                        {
                                $query = "UPDATE 
                                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['smarty_cache_config']."
                                SET
                                cache_lifetime=$value
                                WHERE
                                mod_dir='".$tokens["1"]."'
                                AND
                                tpl_file='".$tokens["2"]."'
                                ";
                                
                                $inicrond_db->Execute($query);
                        }
                }
                
                /*
                $smarty->clear_all_cache();
                
                USER_file_put_contents("../../cache/index.html", '');
                */
                
                $module_content .=  "<b>".$_LANG['options_updated']."</b>";
        }
        
        //get all options here.
        
        $query = "SELECT
        mod_dir, tpl_file, cache_lifetime
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['smarty_cache_config']."
        ";
        
        $rs = $inicrond_db->Execute($query);
        
        $settings = array();
        $i = 0 ;
        $rs = $inicrond_db->Execute($query);
        
        while($fetch_result = $rs->FetchRow())
        {
                $drop_list = generate_time_drop_list("&mod_dir=".$fetch_result["mod_dir"]."&tpl_file=".$fetch_result["tpl_file"]."&", $fetch_result["cache_lifetime"]);
                
                $settings[$fetch_result["mod_dir"]][$i] = array(
                "tpl_file" => $fetch_result["tpl_file"],
                "drop_list" => $drop_list
                );
                
                $i ++;
        }//end of while.
        
        $smarty->assign('_LANG',  $_LANG);
        $smarty->assign('settings',  $settings);
        
        $module_content .= $smarty->fetch($_OPTIONS['theme']."/smarty_cache_config.tpl");
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>