<?php
/*
    $Id: smarty_array_to_html_function.php 78 2005-12-21 03:16:28Z sebhtml $

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

function smarty_array_to_html_function($params)
{
	global $smarty, $_OPTIONS;
	$smarty->assign('params', $params);
	
	$tmp['template_dir'] = $smarty->template_dir;
	$smarty->template_dir = __INICROND_INCLUDE_PATH__.'templates/';
	
	$out = $smarty->fetch($_OPTIONS['theme'].'/smarty_array_to_html_function.tpl');
	$smarty->template_dir = $tmp['template_dir'];
	return $out;
}

?>