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

Copyright (C) 2004  Sebastien Boisverthttp://www.gnu.org/copyleft/gpl.html

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

//
//---------------------------------------------------------------------
*/
//-------------------
// liste de liens
//--------------------
define('__INICROND_INCLUDED__', TRUE);
define('__INICROND_INCLUDE_PATH__', '../../');
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';
include 'includes/languages/'.$_SESSION['language'].'/lang.php';

include __INICROND_INCLUDE_PATH__.'modules/groups/includes/functions/access.inc.php';
include __INICROND_INCLUDE_PATH__.'modules/members/includes/functions/access.inc.php';



if(
isset($_GET['group_id']) && 
$_GET['group_id'] != "" &&
(int) $_GET['group_id'] &&
is_in_charge_of_group($_SESSION['usr_id'], $_GET['group_id'])

)
{
        $module_title =  $_LANG['get_group_emails'];
        
	
        //show some informations.
        $query = "SELECT
	
        group_id,
        group_name,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id AS cours_id,
        cours_code,
        cours_name
        
        
        FROM 
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']." ,
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']." 
        WHERE 
        group_id=".$_GET['group_id']."
        AND
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours'].".cours_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups'].".cours_id
        ";
        
        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        
        foreach($fetch_result AS $key => $value)
        {
                $module_content .= $_LANG[$key]. " : ".$value."<br />";
        }
        
        $module_content .= "<br /><br />";
        
	$query = "SELECT 
	usr_email,
	usr_nom,
	usr_prenom
	FROM 
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].",
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs']."
	
	WHERE
	".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['usrs'].".usr_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups_usrs'].".usr_id
	AND
	group_id=".$_GET['group_id']."
	ORDER BY usr_nom ASC
	";
	
	$rs = $inicrond_db->Execute($query);
        while($fetch_result = $rs->FetchRow())
        {
                $module_content .= "\"".$fetch_result['usr_nom'].", ".$fetch_result['usr_prenom']."\" &lt;".$fetch_result['usr_email']."&gt;,<br />";
        }
        
        
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>