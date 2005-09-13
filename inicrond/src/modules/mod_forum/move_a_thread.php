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
define('__INICROND_INCLUDED__', TRUE);//security
define('__INICROND_INCLUDE_PATH__', '../../');//path
include __INICROND_INCLUDE_PATH__.'includes/kernel/pre_modulation.php';//init inicrond kernel
include 'includes/languages/'.$_SESSION['language'].'/lang.php';//include lang file.
//the lang file is no included in the pre_modulation script because script such as download.php does not 
//require lang variables.
include "includes/functions/access.php";
include "includes/functions/conversion.inc.php";

if(isset($_GET["forum_sujet_id"]) AND
$_GET["forum_sujet_id"] != "" AND
(int) $_GET["forum_sujet_id"] AND
$forum_discussion_id = sujet_2_discussion($_GET["forum_sujet_id"]) AND
is_mod($_SESSION['usr_id'], $forum_discussion_id)

) //changer de sectio
//changer de forum...
{
	
	if(!isset($_POST["envoi"]))//forumulaire
	{
                //$module_content .= $_LANG["10"]["transfer_img"];
                
		//---------------
		//la liste déroulante :::
		//----------------
                include "includes/forms/move_thread.form.php";
                
	}
	elseif(isset($_POST["forum_discussion_id"]) AND
	$_POST["forum_discussion_id"] != "" AND
        (int) $_POST["forum_discussion_id"] AND
        
        is_mod($_SESSION['usr_id'], $_POST["forum_discussion_id"])
        
	
        )//changements
	{
                
                //$queries["UPDATE"] ++; // comptage
                
		$query = "
		UPDATE
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
		SET
		forum_discussion_id=".$_POST["forum_discussion_id"]."
		WHERE
		".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets'].".forum_sujet_id=".$_GET["forum_sujet_id"]."
		";
                
                $inicrond_db->Execute($query);
		include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
                js_redir("thread_inc.php?forum_sujet_id=".$_GET["forum_sujet_id"]."");
	}
	
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>