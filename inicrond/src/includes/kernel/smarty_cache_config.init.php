<?php
/*
    $Id$

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
/*
Changes :

december 15, 2005
	I formated the code correctly.
	
		--sebhtml

*/
if(!__INICROND_INCLUDED__)
{
	exit();
}

if(!is_file($_OPTIONS["file_path"]['smarty_cache_config']))
{
	$query = "SELECT
	mod_dir, tpl_file, cache_lifetime
	FROM 
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['smarty_cache_config']."
	";
	
	$rs = $inicrond_db->Execute($query);
	
	$content = "<?php
	";
	
	while($fetch_result = $rs->FetchRow())  
	{	
		$content .= "
		\$_OPTIONS['smarty_cache_config']['".$fetch_result["mod_dir"]."']['".$fetch_result["tpl_file"]."'] = ".$fetch_result["cache_lifetime"].";";
	}//end of while.
	
	$content .= "
?>";
	
	USER_file_put_contents($_OPTIONS["file_path"]['smarty_cache_config'], $content);
}

include $_OPTIONS["file_path"]['smarty_cache_config'];

?>