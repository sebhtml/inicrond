<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//

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
if(!__INICROND_INCLUDED__){exit();}

if(!is_file($_OPTIONS["file_path"]["options_variable"]))
{



$query = 
"SELECT 
opt_name,
opt_value
FROM 
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_options']."
";
  
  $content = "<?php
";

$rs = $inicrond_db->Execute($query);
    
while($fetch_result = $rs->FetchRow())  
{
$content .= "\$_OPTIONS['".$fetch_result['opt_name']."'] = '".str_Replace('\'','\\\'', $fetch_result['opt_value'])."';
";
}



$content .= "
?>";

USER_file_put_contents($_OPTIONS["file_path"]["options_variable"], $content);
}

include $_OPTIONS["file_path"]["options_variable"];

$inicrond_db->debug = 0; //$_OPTIONS['debug_mode'] ;//adodb debug mode
//echo $_OPTIONS['preg_file_name'];
?>
