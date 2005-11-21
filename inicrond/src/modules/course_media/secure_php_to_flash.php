<?php
//$Id$
/*
//---------------------------------------------------------------------
//
//

//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond
//
//---------------------------------------------------------------------
*/
/*
inicrond
Copyright (C) 2004  Sebastien Boisvert

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
*/
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

//here I check if the person can do this exercie .


//header("Content-type: application/x-www-urlform-encoded");


//get the chapitre_media_id
/*
$query = "
SELECT
chapitre_media_id
FROM
".
$_OPTIONS['table_prefix'].$_OPTIONS['tables']["courses_sess_vars"]."
WHERE

php_session_id='".session_id()."'
";



*/	
echo "&secure_str=".$_SESSION["secure_str"]."&chapitre_media_id=".$_SESSION['chapitre_media_id'];


/*	
$query = "INSERT INTO
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['scores']."
(
session_id,
usr_id,
chapitre_media_id,
time_stamp_start,
time_stamp_end,
secure_str
)
VALUES
(
".$_SESSION['session_id'].",
".$_SESSION['usr_id'].",
".$_SESSION['chapitre_media_id'].",
".$inicrond_mktime.",
".$inicrond_mktime.",
'$HEXA_TAG'
)";
$inicrond_db->Execute($query);
*/


//stock a new variable in the database...


$module_title = "secure_php_to_flash" ;

include __INICROND_INCLUDE_PATH__."includes/kernel/page_view.php";

?>