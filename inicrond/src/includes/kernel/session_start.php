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


if(!isset($_SESSION['usr_id']))//default values...
{
	$_SESSION['usr_time_decal'] = $_OPTIONS['usr_time_decal'] ;//pouir le cégep
	$_SESSION['language'] = $_OPTIONS['language'] ;//pouir le cégep
	$_SESSION['SUID'] = 0 ;
}

$_RUN_TIME['results_per_page'] = $_OPTIONS['results_per_page'] ;
$_RUN_TIME['debug_mode'] = $_OPTIONS['debug_mode'];

//get the HTMLArea_language

if ($_SESSION['language'] == 'fr-ca')
{
	$_RUN_TIME['HTMLArea_language'] = 'fr';
}
else
{
	$_RUN_TIME['HTMLArea_language'] = 'en';
}

?>