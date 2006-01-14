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

/**
 * return the content of a file
 *
 * @param        string  $file       a file adress
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function USER_file_get_contents($file)
{
	$fp = fopen($file, 'r');
	
	$size = fileSize($file) ? fileSize($file) : 999999;//bug at cegep de Lévis-Lauzon, fileSize returns 0
	
	$output = fread($fp, $size);
	
	fclose($fp);
	
	return $output;
}

/**
 * write a file
 *
 * @param        string  $file       a file adress
 * @param        string  $content      the content of the file
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function USER_file_put_contents($file, $content)
{
	$fp = fopen($file, 'w+');
	
	fwrite($fp, $content);
	
	fclose($fp);
	
	return TRUE;
}

?>