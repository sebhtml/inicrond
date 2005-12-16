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

//version constants.
include __INICROND_INCLUDE_PATH__."includes/constants/version.inc.php";

session_set_cookie_params ( 0, '/',  NULL,  0 );
session_name (md5(APPLICATION_UNIX_NAME));
session_start();//

define("PEAR_PATH", __INICROND_INCLUDE_PATH__."libs/PEAR/");

// Don't change the order!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ;P

include __INICROND_INCLUDE_PATH__."includes/constants/sprintf_formats.php";
include __INICROND_INCLUDE_PATH__."includes/kernel/error_handling.php";
include __INICROND_INCLUDE_PATH__."includes/functions/get_cours_infos.php"; //this functuion is used almost everywhere.
include __INICROND_INCLUDE_PATH__."includes/functions/file_functions.php";//those function are needed to write and read file.
include __INICROND_INCLUDE_PATH__."includes/etc/files.php";//this file contains the adress of some file .
include __INICROND_INCLUDE_PATH__."includes/functions/inicrond_mktime.php";//abstration layer of mktime, useless nut used.
include __INICROND_INCLUDE_PATH__."includes/functions/inicrond_convert_time_t_to_user_tz.php";//time_t conversion from both directions.
include __INICROND_INCLUDE_PATH__."includes/functions/inicrond_get_time_t_from_user_tz.php";//time_t conversion from both directions.
include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_access.function.php";//security functions.
include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_autres.function.php";//function like echTableauXY
include __INICROND_INCLUDE_PATH__."includes/kernel/db_init.php";//database init
include __INICROND_INCLUDE_PATH__."includes/kernel/options_init.php";//options init.
include __INICROND_INCLUDE_PATH__."includes/kernel/sesson_start.php";//start the session.
include __INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["available_langs.php"];//languages stuff.//get the avaliable languages. fr-ca en-ca
include __INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["themes.php"];//get the avaliable themes
include __INICROND_INCLUDE_PATH__."includes/functions/smarty_array_to_html_function.php";//Smarty plugin home-made.
include __INICROND_INCLUDE_PATH__."includes/kernel/Smarty.init.php";//init Smarty.
include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_date.function.php" ;//date functions
include __INICROND_INCLUDE_PATH__."includes/functions/BBcode.function.php";//BBcode function
include __INICROND_INCLUDE_PATH__.'includes/languages/'.$_SESSION['language'].'/lang.php';//inclure les donnees messages
include __INICROND_INCLUDE_PATH__.$_OPTIONS["file_path"]["date_stuff.inc.php"];//stuff like week number days
include __INICROND_INCLUDE_PATH__."includes/kernel/update_online_time_inc.php";//update ionline time...
include __INICROND_INCLUDE_PATH__."includes/functions/fonctions_Liens.function.php" ;//function that return links, deprecated, but still used.
include __INICROND_INCLUDE_PATH__."includes/kernel/smarty_cache_config.init.php";//get the cache conf for smarty.
include __INICROND_INCLUDE_PATH__."includes/kernel/course_session_update.kernel.php";//update the cour_id field in online_time...
include __INICROND_INCLUDE_PATH__."modules/members/includes/functions/is_teacher_of_at_least_one_course.php";


if ($_OPTIONS['debug_mode'] == '1')
{
	define ('DEBUG', true) ;
}
else
{
	define ('DEBUG', false) ;
}

?>