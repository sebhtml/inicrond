<?php
//$Id$

define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';

$_GET['image'] = $_LANG['visits'];

$ok = FALSE;

$query = "SELECT start_gmt_timestamp AS time_t FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time']."

";

if(isset($_GET['usr_id']) AND
$_GET['usr_id'] != "" AND
(int) $_GET['usr_id'] AND
is_in_charge_of_user($_SESSION['usr_id'], $_GET['usr_id'])

)
{
        $query2 = "SELECT
        usr_name
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
        WHERE 
        usr_id=".$_GET['usr_id']."";
        
        $rs = $inicrond_db->Execute($query2);
        $fetch_result = $rs->FetchRow();
        
        $_GET["image"] .= "_".$fetch_result['usr_name'];//the file name...
        
        $ok = TRUE;
        $query .= " WHERE usr_id=".$_GET['usr_id']."";
}


if(isset($_GET['HTTP_USER_AGENT']) AND
$_GET['HTTP_USER_AGENT'] != "" AND
$_SESSION['SUID']
)
{
        
        $query .= " WHERE HTTP_USER_AGENT LIKE '%".$_GET['HTTP_USER_AGENT']."%'";
        
        $_GET["image"] .= "_".$_GET['HTTP_USER_AGENT'];
        
}

if(
isset($_GET['cours_id']) AND//add cours_id clause.
$_GET['cours_id'] != "" AND
(int) $_GET['cours_id']

)
{
        
        $query .= " AND cours_id=".$_GET['cours_id']."";
}

if(is_numeric($_GET['group_id']) AND
is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']) 
)
{
        
        //////////////////
        //get the cours id for this group.
        
        
        //define the query in one shot...
        $query = "SELECT 
        start_gmt_timestamp AS time_t 
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['online_time'].".usr_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id = ".$_GET['group_id']."
        
        
        ";
        $ok = 1 ;
        
}
if(!$ok)
{
        exit();
}
$_GET["image"] .= ".png";

include __INICROND_INCLUDE_PATH__."includes/class/Peaks_graphic.php";
$Peaks_graphic = new Peaks_graphic;
$Peaks_graphic->inicrond_db = &$inicrond_db;
$Peaks_graphic->title = &$_LANG['GD_sessions_for_ppl'];
$Peaks_graphic->query = &$query;
$Peaks_graphic->render();



?>