<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
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

if(__INICROND_INCLUDED__ AND
isset($_GET['test_id']))
{
        include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_validation.function.php";
        
        $query = "UPDATE 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
        SET
        test_name=\"".filter($_POST['test_name'])."\",
        test_info=\"".filter($_POST['test_info'])."\",
        q_rand_flag='".$_POST['q_rand_flag']."',
        available_results='".$_POST['available_results']."',
        available_sheet='".$_POST['available_sheet']."',
        
        
        do_you_show_good_answers='".$_POST['do_you_show_good_answers']."',
        time_GMT_edit=".inicrond_mktime()."
        WHERE
        test_id=".$_GET['test_id']."
        
        ";
        
        
        
        $inicrond_db->Execute($query);	
        
        
	
        
}
?>
