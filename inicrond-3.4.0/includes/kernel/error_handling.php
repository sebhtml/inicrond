<?php
/*
    $Id: error_handling.php 87 2006-01-01 02:20:14Z sebhtml $

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
//error_reporting(E_ALL & ~E_NOTICE);

function
user_error_handler ($errno, $errmsg, $filename, $linenum, $vars)
{
    $errors[E_ERROR] = "E_ERROR";
    $errors[E_WARNING] = "E_WARNING";
    $errors[E_PARSE] = "E_PARSE";
    $errors[E_NOTICE] = "E_NOTICE";
    $errors[E_CORE_ERROR] = "E_CORE_ERROR";
    $errors[E_CORE_WARNING] = "E_CORE_WARNING";
    $errors[E_COMPILE_ERROR] = "E_COMPILE_ERROR";
    $errors[E_COMPILE_WARNING] = "E_COMPILE_WARNING";
    $errors[E_USER_WARNING] = "E_USER_WARNING";
    $errors[E_USER_ERROR] = "E_USER_ERROR";
    $errors[E_USER_NOTICE] = "E_USER_NOTICE";
    $errors[E_ALL] = "E_ALL";
    //$errors[E_STRICT] = "E_STRICT";

    if ($errno != E_NOTICE)
    {
        echo "
        <span style=\"color: red;\">
        <h1>Error type : ".$errors[$errno]." (".$errno.")</h1>
        Error # : $errno<br />
        <i>Error msg : $errmsg</i><br />
        File : $filename<br />
        Line $linenum<br />
        Variables : $vars<br />
        </span>
        <hr />";
    }
}

$old_error_handler = set_error_handler("user_error_handler");

?>