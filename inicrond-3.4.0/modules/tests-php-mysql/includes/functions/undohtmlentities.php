<?php
/*
    $Id: undohtmlentities.php 91 2006-01-03 21:28:41Z sebhtml $

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

function
undohtmlentities ($string)
{
    //echo 'avant : ' .$string . "<br />\n" ;
    $tmp = get_html_translation_table(HTML_ENTITIES);

    $tmp2 = array();

    foreach ($tmp as $ascii => $html)
    {
        $tmp2 [$html] = $ascii ;
    }

    $string = strtr ($string, $tmp2);

    $string = utf8_encode ($string) ;

    //echo 'apres : ' .$string ."<br />\n" ;
    return $string ;
}

?>