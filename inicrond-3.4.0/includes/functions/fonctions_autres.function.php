<?php
/*
    $Id: fonctions_autres.function.php 78 2005-12-21 03:16:28Z sebhtml $

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
	die();
}
/**
 * return an array as html
 *
 * @param        array  $tableau       a php array
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function retournerTableauXY($tableau)
{
	return smarty_array_to_html_function(array('php_array' => $tableau));
}

/**
 * remove the html entities of a string
 *
 * @param        string  $chaineHtml       a string that contains html entities
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function unhtmlentities($chaineHtml) 
{
        $tmp = get_html_translation_table(HTML_ENTITIES);
        $tmp = array_flip ($tmp);
        $chaineTmp = strtr ($chaineHtml, $tmp);

        return $chaineTmp;
}

?>