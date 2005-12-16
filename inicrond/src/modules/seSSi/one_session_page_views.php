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

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__."modules/seSSi/includes/functions/conversion.inc.php";

include __INICROND_INCLUDE_PATH__.'includes/functions/is_author_of_session_id.php';

$SELECT_WHAT = 
//requ�e pour toutes les sessions...
"
SELECT 
page_id,
gmt_timestamp, 
requested_url,
usr_page_title,
REMOTE_PORT,
generate_delta_time,
HTTP_KEEP_ALIVE,
HTTP_CONNECTION

";

$FROM_WHAT = "
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['page_views']."

";



$it_is_ok = FALSE;

//base url pour le tableau
$base = "../../modules/seSSi/one_session_page_views.php?";


if(isset($_GET['session_id']) &&//un membre...
$_GET['session_id'] != "" &&
(int) $_GET['session_id'] &&
is_in_charge_of_user($_SESSION['usr_id'], session_id_to_usr($_GET['session_id']))
{
        $it_is_ok = TRUE;
        
        $base .= "&session_id=".$_GET['session_id'];
        
        $WHERE_CLAUSE = "
        WHERE
        
        session_id=".$_GET['session_id']."
        
        ";

        $query = "SELECT 
        usr_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."
        WHERE
        session_id=".$_GET['session_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
        
        ";
        
        $rs = $inicrond_db->Execute($query);
        $f = $rs->FetchRow();
        
        
        //-----------------------
        // titre
        //---------------------
        
        
        
	
        $module_title =  $_LANG['seSSi'];
        
        
}

if(!$it_is_ok)
{
        exit();
}

$fields = array(

	'page_id' => array(
	"col_title" => $_LANG['page_id'],
	"col_data" => "\$unit = \$f['page_id'];",
	"no_statistics" => TRUE
	),
	
	'usr_page_title' => array(
	"col_title" => $_LANG['usr_page_title'],
	"col_data" => "\$unit = retournerHref(\$f['requested_url'], \$f[\"usr_page_title\"]);",
	"no_statistics" => TRUE
	),
	
	'REMOTE_PORT' => array(
	"col_title" => $_LANG['REMOTE_PORT'],
	"col_data" => "\$unit = \$f[\"REMOTE_PORT\"];",
	"no_statistics" => TRUE
	),
	'generate_delta_time' => array(
	"col_title" => $_LANG['generate_delta_time'],
	"col_data" => "\$unit = \$f[\"generate_delta_time\"];"
	),
	"gmt_timestamp" => array(
	"col_title" => $_LANG['date'],
	"col_data" => "\$unit = format_time_stamp(\$f['gmt_timestamp']);",
	"no_statistics" => TRUE
	),	
	
	'HTTP_KEEP_ALIVE' => array(
	"col_title" => $_LANG['HTTP_KEEP_ALIVE'],
	"col_data" => "\$unit = \$f[\"HTTP_KEEP_ALIVE\"];",
	"no_statistics" => TRUE
	),
	"HTTP_CONNECTION" => array(
	"col_title" => $_LANG["HTTP_CONNECTION"],
	"col_data" => "\$unit = \$f[\"HTTP_CONNECTION\"];",
	"no_statistics" => TRUE
	)


);

include __INICROND_INCLUDE_PATH__.'includes/class/Table_columnS.class.php';

$mon_tableau = new Table_columnS ();

$query = $SELECT_WHAT.$FROM_WHAT.$WHERE_CLAUSE;

//echo $sql;

$mon_tableau->sql_base=($query);//la requete de base
$mon_tableau->inicrond_db=&$inicrond_db;//ok
$mon_tableau->base_url=($base);//ok
$mon_tableau->cols=($fields);//ok
$mon_tableau->_LANG=($_LANG);//ok
$mon_tableau->per_page = $_OPTIONS['results_per_page'];

include __INICROND_INCLUDE_PATH__."includes/functions/statistiques.function.php";//fonctions statistiques...


//session informations.

$fields = array(

	'session_id' => array(
	"col_title" => $_LANG['sess_id'],
	"col_data" => "\$unit = 
	\$f[\"session_id\"];"
	),
	
	'usr_name' => array(
	"col_title" => $_LANG['usr_name'],
	"col_data" => "\$unit =  retournerHref(\"../../modules/members/one.php?usr_id=\".\$f[\"usr_id\"], \$f[\"usr_name\"]);"
	),
	
	'usr_number' => array(
	"col_title" => $_LANG['usr_number'],
	"col_data" => "\$unit = \$f[\"usr_number\"];",
	"no_statistics" => TRUE
	),
		
	'start_gmt_timestamp' => array(
	"col_title" => $_LANG['start_gmt_timestamp'],
	"col_data" => "\$unit = format_time_stamp(\$f['start_gmt_timestamp']);",
	"no_statistics" => TRUE
	),		
	
	
	'end_gmt_timestamp' => array(
	"col_title" => $_LANG['end_gmt_timestamp'],
	"col_data" => "\$unit = format_time_stamp(\$f['end_gmt_timestamp']);",
	"no_statistics" => TRUE
	),
	
	"end_gmt_timestamp-start_gmt_timestamp" => array(
	"col_title" => $_LANG['elapsed_time'],
	"col_data" => "\$unit = format_time_length(\$f[\"end_gmt_timestamp-start_gmt_timestamp\"]);"
	),
	
	'REMOTE_ADDR' => array(
	"col_title" => $_LANG['REMOTE_ADDR'],
	"col_data" => "\$unit = \$f[\"REMOTE_ADDR\"];",
	"no_statistics" => TRUE
	),
	
	'dns' => array(
	"col_title" => $_LANG['dns'],
	"col_data" => "\$unit = \$f[\"dns\"];",
	"no_statistics" => TRUE
	),
	
	'HTTP_USER_AGENT' => array(
	"col_title" => $_LANG['HTTP_USER_AGENT'],
	"col_data" => "\$unit =  \"<span style=\\\"font-size: $font_size;\\\" title=\\\"\".\$f[\"HTTP_USER_AGENT\"].\"\\\">\".\$f[\"HTTP_USER_AGENT\"].\"</span>\";",
	"no_statistics" => TRUE
	)

);	


$mon_tableau2 = new Table_columnS();

$query = 
//requ�e pour toutes les sessions...
"
SELECT 
session_id,
start_gmt_timestamp, 
end_gmt_timestamp, 
REMOTE_ADDR, 
end_gmt_timestamp-start_gmt_timestamp,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id,
dns,
usr_name,

HTTP_USER_AGENT,
usr_number

FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
WHERE
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
AND
session_id=".$_GET['session_id']."
";


$mon_tableau2->sql_base=($query);//la requete de base
$mon_tableau2->inicrond_db=&$inicrond_db;//ok
$mon_tableau2->base_url=($base);//ok
$mon_tableau2->cols=($fields);//ok
$mon_tableau2->_LANG=($_LANG);//ok
$mon_tableau2->per_page=$_OPTIONS['results_per_page'];

include __INICROND_INCLUDE_PATH__."includes/functions/usr_scored.function.php";



$module_content .= $mon_tableau2->OUTPUT () ;

//end of session informations.


$module_content .= $mon_tableau->OUTPUT () ;




include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';

?>