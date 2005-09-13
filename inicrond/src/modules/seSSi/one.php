<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : l'index du site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond



//
//---------------------------------------------------------------------
*/
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';

include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';


/*
FROM_WHAT ET WHERE_CLAUSE

*/
$now_GMT = inicrond_mktime();

$SELECT_WHAT = 
//requête pour toutes les sessions...
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
usr_number,
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id AS cours_id,
cours_name
";

$FROM_WHAT = "
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."

";

$WHERE_CLAUSE = "
WHERE
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".cours_id
AND
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id

";

$it_is_ok = FALSE;
//base url pour le tableau
$base = "../../modules/seSSi/one.php";


if(isset($_GET['usr_id']) AND//un membre...
$_GET['usr_id'] != "" AND
(int) $_GET['usr_id'] AND
is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id'])


)
{
        
        if(isset($_GET['cours_id']) AND
        $_GET['cours_id'] != "" AND
        (int) $_GET['cours_id']
        )
        {
                $WHERE_CLAUSE .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".cours_id=".$_GET['cours_id'];
                
        }
        
	$module_content .= "<a href=\"../../modules/seSSi/sessions_img.php?usr_id=".$_GET['usr_id']."\" >".$_LANG['GD_sessions_for_ppl']."</a><br />";
	
	$module_content .= "<a href=\"../../modules/seSSi/normal_dist_time_img.php?usr_id=".$_GET['usr_id']."\" >".$_LANG['distribution_of_session_length']."</a><br />";
	
        
        $it_is_ok = TRUE;
        $sql2 = "SELECT 
        usr_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE
        usr_id=".$_GET['usr_id']."
        ;";
        
        $rs = $inicrond_db->Execute($sql2);
        $f = $rs->FetchRow();
        
        //-----------------------
        // titre
        //---------------------
        
        
        
	
        $module_title =  $_LANG['seSSi'];
        
        $WHERE_CLAUSE  .= " AND ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_GET['usr_id'];
        $base .= "?usr_id=".$_GET['usr_id'];
        
        
        
}
elseif(isset($_GET['group_id']) AND
$_GET['group_id'] != "" AND
(int) $_GET['group_id'] AND

is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']) 

)//un groupe...
{
        $it_is_ok = TRUE;
        
        $sql2 = "SELECT 
        group_name
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        group_id=".$_GET['group_id']."
        ;";
        
        $rs = $inicrond_db->Execute($sql2);
        $fetch_result = $rs->FetchRow();
        //-----------------------
        // titre
        //---------------------
        
        
        
	
        $module_title =  $_LANG['seSSi'];
        
        $WHERE_CLAUSE .= " AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
        ";
        
        $FROM_WHAT .= ",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."";//table groups_usrs
        $base .= "?group_id=".$_GET['group_id']."";
        
        
        
        
        
        
}
elseif(isset($_GET['start']) AND
$_GET['start'] != "" AND
(int) $_GET['start'] AND
isset($_GET["end"]) AND
$_GET["end"] != "" AND
(int) $_GET["end"] AND

is_numeric($_GET['cours_id']) AND
is_in_charge_in_course($_SESSION['usr_id'], $_GET['cours_id'])
)//par date
{
        $it_is_ok = TRUE;
        $base .= "?start=".$_GET['start']."&end=".$_GET["end"]."&cours_id=".$_GET['cours_id'];
        
        $WHERE_CLAUSE .= "AND
        start_gmt_timestamp>=".$_GET['start']."
        AND
        start_gmt_timestamp<".$_GET["end"]."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".cours_id = ".$_GET['cours_id']."";
        
        $module_title =  $_LANG['seSSi'];
        $module_content .= "<br /><br />".$_LANG['start_date']." : ".format_time_stamp($_GET['start']);
        
        $module_content .= "<br />".$_LANG['end_date']." : ".format_time_stamp($_GET["end"])."<br /><br />";
        
}
elseif($_SESSION['SUID'])//tous les membres
{
	
	$module_content .= "<a href=\"../../modules/seSSi/sessions_img.php\" >".$_LANG['GD_sessions_for_ppl']."</a><br />";
	
	$module_content .= "<a href=\"../../modules/seSSi/normal_dist_time_img.php\" >".$_LANG['distribution_of_session_length']."</a><br />";
	
        $module_title =  $_LANG['seSSi'];
        $it_is_ok = TRUE;
        
        $base .= "?";
}

if(!$it_is_ok)
{
        exit();
}


//$module_content .= "<img src=\"graph2.php?usr_id=".$_GET['usr_id']."\" />";

//
//TABLEAU TRIÉ...
//


$font_size = 14;//for the text that is small.

include "includes/functions/infos_for_session.php";

if(isset($_GET['usr_id'])//for  usr

)
{
        
        $show_scores = "FALSE";
        $show_results = "FALSE";
        $show_dl_acts = "FALSE";
        
	if( 
	is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id'])
	)
	{
                $show_scores = "TRUE";
	}
	/*
	
        
        CAN_VIEW_DOWNLOADS_FOR_SESSION
        CAN_VIEW_DOWNLOADS_FOR_MY_SESSION
        */
	
	$show_results = "TRUE";
	
	
	
	$show_dl_acts = "TRUE";
	
        $infos_session_txt = ".infos_for_session(\$f[\"session_id\"], $show_scores, $show_results, $show_dl_acts)";
        
        
        
}


$session_link = "<a href=\\\"one_session_page_views.php?session_id=\".\$f[\"session_id\"].\"\\\">\".\$f[\"session_id\"].\"</a>";



$fields = array(

'session_id' => array(
"col_title" => $_LANG['sess_id'],
"col_data" => "

\$unit =  \"$session_link\"$infos_session_txt;"
),

'usr_name' => array(
"col_title" => $_LANG['usr_name'],
"col_data" => "\$unit =  retournerHref(\"../../modules/members/one.php?usr_id=\".\$f[\"usr_id\"], \$f[\"usr_name\"]);"
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
'cours_name' => array(
"col_title" => $_LANG['cours_name'],
"col_data" => "\$unit =  \"<a href=\\\"../../modules/courses/inode.php?cours_id=\".\$f[\"cours_id\"].\"\\\">\".\$f[\"cours_name\"].\"</a>\";"
),
/*
"expire_GMT_timestamp" => array(
"col_title" => $_LANG["expire_GMT_timestamp"],
"col_data" => "\$unit = format_time_stamp(\$f['expire_GMT_timestamp']);",
"no_statistics" => TRUE
),
"re_ask_password_ts_GMT" => array(
"col_title" => $_LANG["re_ask_password_ts_GMT"],
"col_data" => "\$unit = format_time_stamp(\$f['re_ask_password_ts_GMT']);",
"no_statistics" => TRUE
),
*/
"end_gmt_timestamp-start_gmt_timestamp" => array(
"col_title" => $_LANG['elapsed_time'],
"col_data" => "\$unit = format_time_length(\$f[\"end_gmt_timestamp-start_gmt_timestamp\"]);"
),

/*"php_session_id" => array(
"col_title" => $_LANG['session_id'],
"col_data" => "\$unit =  \"<span style=\\\"font-size: $font_size;\\\" title=\\\"\".\$f[\"php_session_id\"].\"\\\">\".\$f[\"php_session_id\"].\"</span>\";"
),*/
/*
"is_online" => array(
"col_title" => $_LANG["is_online"],
"col_data" => "\$unit =  (\$f[\"is_online\"]) ? \$_LANG[\"yes\"] : \$_LANG[\"no\"];",
"no_statistics" => TRUE
),
"3-end_gmt_timestamp" => array(
"col_title" => $_LANG['last_page_time'],
"col_data" => "\$unit =  (\$f[\"is_online\"]) ? format_time_length(\$f[\"$now_GMT-end_gmt_timestamp\"]) : \"\";",
"no_statistics" => TRUE
),
*/
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

),	
/*
'REMOTE_PORT' => array(
"col_title" => $_LANG['REMOTE_PORT'],
"col_data" => "\$unit = \$f[\"REMOTE_PORT\"];",
"no_statistics" => TRUE
)
/*
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
*/

);	
include __INICROND_INCLUDE_PATH__."includes/class/Table_columnS.class.php";

$mon_tableau = new Table_columnS();

$query = $SELECT_WHAT.$FROM_WHAT.$WHERE_CLAUSE;


$mon_tableau->sql_base = $query;//la requete de base
$mon_tableau->cols = $fields;//les colonnes
$mon_tableau->base_url=$base;//l'url de base pour le fichier php.
$mon_tableau->_LANG=$_LANG;//le language...
$mon_tableau->inicrond_db=$inicrond_db;
$mon_tableau->per_page=$_OPTIONS['results_per_page'];

include __INICROND_INCLUDE_PATH__."includes/functions/usr_scored.function.php";

include __INICROND_INCLUDE_PATH__."includes/functions/statistiques.function.php";//fonctions statistiques...

$module_content .= $mon_tableau->OUTPUT();




include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>
