<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//

//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in  the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

//
//---------------------------------------------------------------------
*/
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';

$query = "SELECT 
usr_id, usr_name, usr_nom, usr_prenom,
usr_number
FROM
".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']." 
WHERE 
usr_activation=1
";
$base = __INICROND_INCLUDE_PATH__."modules/members/members.php?";

if(!isset($_GET['start'])  AND
$_SESSION['SUID']
) //ensei
{
        $module_content .= "<h2><a href=\"".__INICROND_INCLUDE_PATH__."modules/admin/admin_menu.php\">".$_LANG['admin']."</a></h2>";
        
        $module_title =  $_LANG['members'];
        
        
        $module_content .=  " [ ";
        $module_content .= retournerHref(__INICROND_INCLUDE_PATH__."modules/seSSi/one.php", $_LANG['seSSi']);//
        $module_content .=  " ] ";
        
        
        
	$module_content .=  " [ ";
        $module_content .= retournerHref(__INICROND_INCLUDE_PATH__."modules/marks/main.php", $_LANG['marks']);//
        $module_content .=  " ] ";
        
	$module_content .=  " [ ";
        $module_content .= retournerHref(__INICROND_INCLUDE_PATH__."modules/tests-results/results.php", $_LANG['tests-results']);//
        $module_content .=  " ] ";
        
        
        
        
        
        $it_is_ok = TRUE;
}



if(!$it_is_ok)
{
        exit();
}

$fields = array(

'usr_name' => array(
"col_title" => $_LANG['usr_name'],
"col_data" => "\$unit = retournerHref(\"".__INICROND_INCLUDE_PATH__."modules/members/one.php?usr_id=\".\$f[\"usr_id\"], \$f[\"usr_name\"]).\" \".info_links(\$f[\"usr_id\"]);",
"no_statistics" => TRUE
),
'usr_number' => array(
"col_title" => $_LANG['usr_number'],
"col_data" => "\$unit = \$f[\"usr_number\"];",
"no_statistics" => TRUE
),
'usr_nom' => array(
"col_title" => $_LANG['usr_nom'],
"col_data" => "\$unit = \$f[\"usr_nom\"];",
"no_statistics" => TRUE
),
'usr_prenom' => array(
"col_title" => $_LANG['usr_prenom'],
"col_data" => "\$unit = \$f[\"usr_prenom\"];",
"no_statistics" => TRUE
),		
);

include __INICROND_INCLUDE_PATH__."includes/class/Table_columnS.class.php";
include __INICROND_INCLUDE_PATH__."includes/functions/usr_scored.function.php";
$mon_tableau = new Table_columnS;

$mon_tableau->sql_base = $query;//la requete de base
$mon_tableau->cols = $fields;//les colonnes
$mon_tableau->base_url=$base;//l'url de base pour le fichier php.
$mon_tableau->_LANG=$_LANG;//le language...
$mon_tableau->inicrond_db=$inicrond_db;
$mon_tableau->per_page=$_OPTIONS['results_per_page'];

$module_content .= $mon_tableau->OUTPUT();



include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>
