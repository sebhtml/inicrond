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
        $module_title =  $_LANG['lang_dev'];
        
        //al those module are based on the en-ca language.
        
        //done.
        $module_content .= "<a href=\"populate_db.php\">".$_LANG['populate_db']."</a><br /><br />";
        
        //done.
        $module_content .= "<a href=\"add_lang.php\">".$_LANG['add_lang']."</a><br />";
        //done.
        $module_content .= "<a href=\"add_lang_file.php\">".$_LANG['add_lang_file']."</a><br />";
        
        //done.
        $module_content .= "<a href=\"add_string.php\">".$_LANG['add_string']."</a><br /><br />";
        
        //done
        $module_content .= "<a href=\"check_double_string.php\">".$_LANG['check_double_string']."</a><br />";
        
        //done
        $module_content .= "<a href=\"check_double_content.php\">".$_LANG['check_double_content']."</a><br />";
        
        //done
        $module_content .= "<a href=\"compare_lang.php\">".$_LANG['compare_lang']."</a><br />";
        $module_content .= "<a href=\"list_deprecated_strings.php\">".$_LANG['list_deprecated_strings']."</a><br />";
        //done.
        $module_content .= "<a href=\"list_not_traducted_strings.php\">".$_LANG['list_not_traducted_strings']."</a><br /><br />";
        
        //edit string...
        $module_content .= "<a href=\"edit_strings.php\">".$_LANG['edit_strings']."</a><br />";
        
        $module_content .= "<a href=\"remove_string.php\">".$_LANG['remove_string']."</a><br />";
        
        $module_content .= "<a href=\"move_string.php\">".$_LANG['move_string']."</a><br />";
        
        $module_content .= "<a href=\"write_lang_files.php\">".$_LANG['write_lang_files']."</a><br /><br />";
        
        
        //done
        $module_content .= "<a href=\"reset_db.php\">".$_LANG['reset_db']."</a><br />";
        
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>