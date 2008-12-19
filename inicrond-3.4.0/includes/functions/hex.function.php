<?php
/*
    $Id: hex.function.php 99 2006-01-08 02:49:00Z sebhtml $

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


/**
 * generate an hexadecimal string with 32 chars
 *
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function hex_gen_32()
{
    global $_OPTIONS ;

    $i = 32;//number of digit
    $out = '';

    while($i)
    {
            $out .= dechex(rand(0, 15));
            $i--;//decrementation
    }

    if (is_file ($_OPTIONS["file_path"]["uploads"].'/'.$out))
    {
        // recursive call to have a new one...
        $out = hex_gen_32() ;
    }

    return $out;//give out the answer
}

?>
