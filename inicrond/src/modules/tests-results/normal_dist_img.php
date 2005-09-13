<?php
//$Id$
$_GET['image'] = "png.png";
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';

include 'includes/languages/'.$_SESSION['language'].'/lang.php';
//pear
include __INICROND_INCLUDE_PATH__."modules/tests-php-mysql/includes/functions/conversion.function.php";//conversions

include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';       
$_GET['image'] = $_LANG['test_marks'];	
$query = "SELECT 
your_points/max_points*100 AS value
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results']."
WHERE 
time_GMT_end>time_GMT_start

";

//validation
$ok = FALSE;

if($_SESSION['SUID'])
{
        $ok = TRUE;
        
}

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
        $query .= " AND usr_id=".$_GET['usr_id']."";
}

if(isset($_GET['test_id']) AND
$_GET['test_id'] != "" AND
(int) $_GET['test_id'] AND
(

isset($_GET['usr_id'])

OR

is_teacher_of_cours($_SESSION['usr_id'],test_2_cours($_GET['test_id']))
)

//can he see a usr and a test at the same time ?


)
{
        $query2 = "
	SELECT
        
        
	test_name
        
	FROM
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests']."
        
	WHERE
	test_id=".$_GET['test_id']."
	
	";
	
	$rs = $inicrond_db->Execute($query2);
        $fetch_result = $rs->FetchRow();
        
        $_GET["image"] .= "_".str_replace(" ", "_", $fetch_result['test_name']);//the file name...
        
        $ok = TRUE;
        $query .= " AND test_id=".$_GET['test_id']."";
}
elseif(is_numeric($_GET['group_id']) AND
is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id']) 
)
{
        $ok = 1 ;
        //////////////////
        //get the cours id for this group.
        
        
        //define the query in one shot...
        
        
        
        $query = "SELECT 
        
        your_points/max_points*100 AS value
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".usr_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".group_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id = ".$_GET['group_id']."
        AND
        time_GMT_end>time_GMT_start
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['tests'].".test_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['results'].".test_id
        
        ";
        /*
        echo $query;
        exit;
        */
}

$_GET["image"] .= ".png";

if(!$ok)//access denied
{
        exit();
}


include __INICROND_INCLUDE_PATH__."includes/class/Histogram_graphic.php";
$Histogram_graphic = new Histogram_graphic;
$Histogram_graphic->inicrond_db = &$inicrond_db;
$Histogram_graphic->title = &$_LANG['GD_distribution_of_score'];
$Histogram_graphic->query = &$query;
$Histogram_graphic->preprocessor = "X_func";
$Histogram_graphic->render();

?>