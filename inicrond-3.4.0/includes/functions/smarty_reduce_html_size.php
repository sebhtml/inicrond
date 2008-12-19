<?php
/*
    $Id: smarty_reduce_html_size.php 72 2005-12-16 02:08:23Z sebhtml $

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
function smarty_reduce_html_size($tpl_source, &$smarty)
{
	$tpl_source = str_replace("\n", '', $tpl_source);//remove the new lines
	$tpl_source = str_replace("\t", '', $tpl_source);//remove the tabulations
	$tpl_source = preg_replace('/[ ]{2,}/', ' ', $tpl_source);//replace 2 or more space by one space
	
	return $tpl_source;
}

?>