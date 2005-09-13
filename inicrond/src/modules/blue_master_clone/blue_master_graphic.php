<?php
//$Id$
$_GET['image'] = "png.png";
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';

include 'includes/languages/'.$_SESSION['language'].'/lang.php';
//pear

include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/ev_id_to_group_id.php";


include "includes/etc/final_mark_formula.php";//init inicrond kernel
//$_GET['image'] = $_LANG['test_marks'];	

include __INICROND_INCLUDE_PATH__."modules/blue_master_clone/includes/functions/inicrond_compute_final_mark.php";

//validation
$ok = FALSE;

$vals = array();

if(
isset($_GET['ev_id']) AND
$_GET['ev_id'] != "" AND
(int) $_GET['ev_id'] AND
is_in_charge_of_group($_SESSION['usr_id'], ev_id_to_group_id($_GET['ev_id']))
)
{
        $query = "SELECT 
        ev_score,
        ev_max,
        ev_weight
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." 
        
        WHERE
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['user_evaluation_scores']." .ev_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." .ev_id
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['evaluations']." .ev_id=".$_GET['ev_id']."
        
        
        ";
	$rs = $inicrond_db->Execute($query);
        
	$dataset = array();
	while($fetch_result = $rs->FetchRow())//ge all entries.
	{
                //add the weighted marks.
                $dataset []= $fetch_result['ev_score']/$fetch_result['ev_max']*$fetch_result['ev_weight'];
	}
	
	$vals = $dataset ;
	$dataset = NULL;
        $ok = 1 ;	
}
elseif(
isset($_GET['group_id']) AND
$_GET['group_id'] != "" AND
(int) $_GET['group_id'] AND
is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id'])//is in charge of the group???.
)
{
        /////////////////
        //get the finals marks dataset.
        
        
        $final_marks_dataset = array();//the array that will contain the final marks data set.
        $query = "SELECT 		
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id AS usr_id
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].",
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
        WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
        
        AND
        group_id=".$_GET['group_id']."
        ORDER BY usr_nom ASC
        
        ";
        $rs = $inicrond_db->Execute($query);
        
        
        $final_marks_dataset = array();
        while($fetch_result = $rs->FetchRow())
        {
                
                $points =  inicrond_compute_final_mark($fetch_result['usr_id'], $_GET['group_id']) ;
                
                
                $final_marks_dataset []= $points['percentage'] ;
                
                //$i++;
        }
        
        
        $vals = $final_marks_dataset;
        $final_marks_dataset = NULL;
        
        $ok = 1 ;
        
        
}


if(!$ok)//access denied
{
        exit();
}



//print_R($vals);
//exit();



include __INICROND_INCLUDE_PATH__."includes/class/Histogram_graphic.php";
$Histogram_graphic = new Histogram_graphic;
$Histogram_graphic->inicrond_db = &$inicrond_db;
$Histogram_graphic->title = &$_LANG['GD_distribution_of_score'];
$Histogram_graphic->query = &$query;
$Histogram_graphic->vals = &$vals;
$Histogram_graphic->preprocessor = "X_func";
$Histogram_graphic->render();
?>