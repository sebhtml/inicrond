<?php
//$Id$
//-----------------------------------
//Config file...
//---------------------------

/*
//---------------------------------------------------------------------
//

//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond




Copyright (C) 2004  Sebastien Boisvert

http://www.gnu.org/copyleft/gpl.html

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

//---------------------------------------------------------------------
*/

if(!__INICROND_INCLUDED__)
{
 exit();
}

$_RUN_TIME["actions_Debug"].= "</table>";

$debug_mod_content .= "=== \$_RUN_TIME ===<br />";
$debug_mod_content .=  nl2br(print_r($_RUN_TIME, TRUE));
$debug_mod_content .=  "=== ===<br />";


	{
$debug_mod_content .=  "=== max_action_id ===<br />";
$debug_mod_content .=  max($_OPTIONS["actions_system"]);//debug
$debug_mod_content .=  "=== ===<br />";
	}

	{
$debug_mod_content .=  "=== benchmark_debug ===<br />";
$end_at_This_very_time = microtime();
$end_at_This_very_time = explode(" ",$end_at_This_very_time);
$end_at_This_very_time = $end_at_This_very_time[1].$end_at_This_very_time[0];

$debug_mod_content .=  ($end_at_This_very_time-$start_at_This_very_time)." seconds<br />";//debug
$debug_mod_content .=  "=== ===<br />";
	}

	
/*
	{
$debug_mod_content .=  "=== phpinfo_debug ===<br />";
ob_start();//for php_info
 phpinfo();//hehe
$debug_mod_content .= ob_get_contents();
ob_clean();//clean the phpinfo
$debug_mod_content .=  "=== ===<br />";
	}*/
	
?>