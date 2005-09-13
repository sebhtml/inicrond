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

//
//---------------------------------------------------------------------
*/


if(!__INICROND_INCLUDED__)
{
die("hacking attempt!!");
}

/**
 * echo a link
 *
 * @param        string  $lelien       url
 * @param        string  $letexte      the text
 * @param        string  $lacible      the target
 * @param        string  $laclasse      the css class
 * @param        string  $title      the onmouseover title
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function echoHref($lelien, $letexte, $lacible="_top", $laclasse="", $title="")
{
echo retournerHref($lelien,$letexte,$lacible,$laclasse,$title) ;
}

/**
 * return a link
 *
 * @param        string  $lelien       url
 * @param        string  $letexte      the text
 * @param        string  $lacible      the target
 * @param        string  $laclasse      the css class
 * @param        string  $title      the onmouseover title
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function retournerHref($lelien,$letexte,$lacible="_top",$laclasse="", $title="")
{
return "<a href=\"$lelien\">$letexte</a>";
}



?>
