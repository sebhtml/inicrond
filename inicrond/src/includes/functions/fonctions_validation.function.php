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
    die();
}


/**
 * ffilter a string
 *
 * @param        string  $string       something to filter
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */

function
filter($string)
{
    global $_OPTIONS;

    if($_OPTIONS['htmlEntities'])
    {
        $string = htmlEntities($string) ;
    }

    if(!get_magic_quotes_gpc())//MAGIC QUOTES
    {
        //$string = addCSlashes($string);
        $string = strstr ("'", "\'", $string) ;
    }

    return $string ;
}

/**
 * ffilter a string without removing < > tags
 *
 * @param        string  $string       something to filter
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */

function
filter_html_preserve($string)
{
    /*
    $tmp = get_html_translation_table(HTML_ENTITIES);

    $tmp2 = array();

    foreach($tmp AS $key => $value)
    {
        if($value != '&quot;' && $value != '&lt;' && $value != '&gt;' && $value != '&amp;')
        {
            $tmp2[$key] = $value;
        }
    }

    if(!get_magic_quotes_gpc())//MAGIC QUOTES
    {
        $string = addSlashes($string);
    }

    $string = strtr ($string, $tmp2);
    */

    //$string = addCSlashes($string);
    $string = filter($string) ;
    return $string ;
}

?>