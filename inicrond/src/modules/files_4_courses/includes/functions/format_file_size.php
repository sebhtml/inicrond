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


/**
* return a string in mega or kilo
*
* @param        integer  $input    size in bytes
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/
function format_file_size($size_in_bytes)
{
    global $_LANG;

    if($size_in_bytes > 1024*1024)//mega
    {
        return ($size_in_bytes/(1024*1024))." ".$_LANG['megabyte']." (".$size_in_bytes." ".$_LANG['byte'].")";
    }
    else//kilo
    {
        return($size_in_bytes/1024)." ".$_LANG['kilobyte']." (".$size_in_bytes." ".$_LANG['byte'].")";
    }
}

?>