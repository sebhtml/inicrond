<?php
/*---------------------------------------------------------------------

$Id$

sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

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
-----------------------------------------------------------------------*/
define("__INICROND_INCLUDED__", TRUE);//security
define("__INICROND_INCLUDE_PATH__", "../../");//path
include __INICROND_INCLUDE_PATH__."includes/kernel/pre_modulation.php";//init inicrond kernel
include "includes/languages/".$_SESSION["language"]."/lang.php";//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not 
//require lang variables.

$module_title = $_LANG['divide_a_group'] ;
$module_content = '' ;

if (!is_chef_of_group($_SESSION['usr_id'], $_GET['group_id']))//echef du groupe seulement
{
	echo $_SESSION['usr_id'] ;
	exit ;
}

/*
groupe A et groupe B

groupe A : 8:00 à 10:10 16

groupe A1 :12

groupe B : 10:00 à 12:00 18

groupe B1 : 12

13:00 à 15:00 groupe A et groupe B
groupe A2 : 4
groupe B2 : 6


laboratoire : 12 ordinateurs

cliquer pour sous-diviser
entrer le nombre de sous-groupe
Vérifier la valeur entrée
Entrer le nombre de personnes dans chaque  sous groupe
Vérifier tous les nombres
Vérifier si la partition est correct
Par ordre alphabétique
Créer les groupes
 
 
 */

//get the group name.

    
	$query = "SELECT 
	group_id,
	group_name,
	cours_id,
	default_pending 
	FROM 
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
	
	WHERE
	group_id=".$_GET['group_id']."
	";
	
	$rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        $cours_id = $fetch_result['cours_id'];
        $group_name = $fetch_result['group_name'];
        
        
// cliquer pour sous-diviser
// entrer le nombre de sous-groupe

//obtenir le nombre d'étudiants
   $query = "SELECT 
        count(*) AS number_of_students
	FROM 
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
	";
        
	
$rs = $inicrond_db->Execute($query);

$fetch_result = $rs->FetchRow();

$number_of_students = $fetch_result ['number_of_students'] ;
$max_number_of_sub_groups = $number_of_students ;

//phase 1 : enter the number of groups
if (!isset($_GET['stage']))
{
	

	if (!isset($_POST['count_sub_groups']))
	{
		$module_content .= '<form method="post">' ;
		$module_content .= '<select name="count_sub_groups">' ;
	
		for ($i = 1 ; $i <= $max_number_of_sub_groups ; $i ++)
		{
		
			$module_content .= '<option value="'.$i.'">'.$i.'</option>' ;
		}
		$module_content .= '</select>' ;
 		$module_content .= '<input type="submit" />' ;
		$module_content .= '</form>' ;

	}
	else
	{
		//echo 'count_sub_groups : ' .$_POST['count_sub_groups'] ;
		if (
		1 <= $_POST['count_sub_groups'] &&
		$_POST['count_sub_groups'] <= $max_number_of_sub_groups)
		{
			
			$_SESSION['count_sub_groups'] = $_POST['count_sub_groups'] ;
			 include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
                        js_redir('divide_a_group.php?group_id='.$_GET['group_id'].'&stage=2');
		}
	

	}

}
//////////////////////////////////////////////////////////////////3
//phase 2 : enter the number in each sub_groups
elseif ($_GET['stage'] == 2)
{

	if (!isset($_POST['submit_phase_2']))
	{
		$module_content .= '<form method="post"><table>' ;
		$module_content .= $number_of_students . '<br / >';
		for ($i = 1 ; $i <= $_SESSION['count_sub_groups'] ; $i ++)
		{
		
			$module_content .= '<tr><td><b>'.$i.'</b></td><td><input type="text" name="amount_'.$i.'" /></td></tr>' ;
		}
 		$module_content .= '<tr><td></td><td><input type="submit" name="submit_phase_2" /></td></tr>' ;
		$module_content .= '</table></form>' ;
		
	}
	else // populate $_SESSION['array_of_count_student_in_each_sub_groups']
	{
		$_SESSION['array_of_count_student_in_each_sub_groups'] = array () ;
		$_SESSION['sum_of_cardinality_of_all_sub_groups'] = 0 ;
		
		foreach ($_POST AS $key => $value)
		{
			if(preg_match("/amount_(.+)/", $key, $tokens))
			{
				$_SESSION['array_of_count_student_in_each_sub_groups'] []= $value ;
				$_SESSION['sum_of_cardinality_of_all_sub_groups'] += $value ;
			}
		}
		 include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
                        js_redir('divide_a_group.php?group_id='.$_GET['group_id'].'&stage=3');
	}
}

elseif ($_GET['stage'] == 3)
{
// Vérifier tous les nombres
// Vérifier si la partition est correct

	if ($_SESSION['sum_of_cardinality_of_all_sub_groups'] != $number_of_students)
	{
		 $module_content .= $_LANG['error_sum_of_cardinalities_of_parts_not_matching'] ;
	 
	}
	else
	{
		$amount_inserted_already = 0 ;
		
		foreach ($_SESSION['array_of_count_student_in_each_sub_groups'] AS $key => $value)
		{
		// Par ordre alphabétique
		// Créer les groupes
	 
	 	$sql = 'insert into '.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].'
		(group_name, cours_id, default_pending)
		values
		(\''.$group_name.' '.date('YmdHis').' '.$key.'\', '.$cours_id.' , \'1\')' ;
		
		$module_content .= '<pre>'.$sql.'</pre>' ;
		$rs = $inicrond_db->Execute($sql);
		
		$group_id = $inicrond_db->Insert_ID () ;
		//$module_content .=  $group_id ;
		// insert the new group
	 
	 	// foreach entry for the group in the db
	 		//INSERT AN entry for this group
	   $query = "SELECT 
	   
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id AS usr_id, 
usr_name, usr_nom, usr_prenom
	FROM 
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].", ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs']."
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id
	AND
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".group_id=".$_GET['group_id']."
	ORDER BY usr_nom ASC
	LIMIT ".$amount_inserted_already.",".$value."";
        
	
        $rs = $inicrond_db->Execute($query);
        
			while($fetch_result = $rs->FetchRow())
			{
				//INSERT CODE HERE.
				$sql = 'insert into 
				'.$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].'
				(usr_id, group_id)
				values
				('.$fetch_result['usr_id'].', '.$group_id.')
				' ;
				$module_content .= '<pre>'.$sql.'</pre>' ;

				$inicrond_db->Execute($sql);
			}
	
			$amount_inserted_already += $value ;
		}
	}

}
include "".__INICROND_INCLUDE_PATH__."includes/kernel/post_modulation.php";


?>