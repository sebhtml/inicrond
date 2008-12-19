<?php
/*
    $Id: version.inc.php 150 2006-08-17 23:06:54Z sebhtml $

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005, 2006  Sébastien Boisvert

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
define('APPLICATION_UNIX_NAME', 'inicrond');
define('APPLICATION_MAJOR_VERSION', 3);
define('APPLICATION_MINOR_VERSION', 3);
define('APPLICATION_RELEASE_NUMBER', 3);
define('APPLICATION_EXTRA_VERSION_TEXT', '');
define('APPLICATION_DEVEL_WEB_SITE', 'http://'.APPLICATION_UNIX_NAME.'.sourceforge.net/');

/*
define('APPLICATION_COMPLETE_RELEASE_NAME', APPLICATION_UNIX_NAME.' '.APPLICATION_MAJOR_VERSION.'.'.APPLICATION_MINOR_VERSION.'.'.APPLICATION_RELEASE_NUMBER.APPLICATION_EXTRA_VERSION_TEXT);
*/

define ('APPLICATION_COMPLETE_RELEASE_NAME', 'inicrond 3.4.0') ;

?>
