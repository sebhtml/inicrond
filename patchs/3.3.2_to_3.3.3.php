<?php
/*
    $Id: 3.3.2_to_3.3.3.php 111 2006-01-15 01:43:32Z sebhtml $

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
put this file in the inicrond root installation.
THe root is in fact the src.
*/

define("__INICROND_INCLUDED__", TRUE);
define("__INICROND_INCLUDE_PATH__", "");
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";

/*
foreach ($_OPTIONS['tables'] as $table_name)
{
    $query = '
    ALTER TABLE
    '.$_OPTIONS["table_prefix"].''.$table_name.'
    TYPE = innodb
    ' ;

    $inicrond_db->Execute ($query) ;
}
*/

?>