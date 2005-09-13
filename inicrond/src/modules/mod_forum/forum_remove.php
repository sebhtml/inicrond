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

if(
isset($_GET["forum_discussion_id"]) AND //on demande-tu ??
$_GET["forum_discussion_id"] != "" AND //pas de chaine vide
(int) $_GET["forum_discussion_id"] AND //chagnement de type

(
can_usr_admin_section($_SESSION['usr_id'], forum_2_section($_GET["forum_discussion_id"]))
))//enlever une section
{
	if(!isset($_POST["envoi"]))
	{
                include "includes/forms/remove_forum.form.php";
                
	}
	else
	{
                $query = "
                SELECT
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id,
                cours_id
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].",
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections']."
                WHERE
                forum_discussion_id=".$_GET["forum_discussion_id"].
                "
                AND
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions'].".forum_section_id=".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sections'].".forum_section_id
                ";
                
                $rs = $inicrond_db->Execute($query);
                $fetch_result = $rs->FetchRow();
                
                $cours_id = $fetch_result['cours_id'];
                
                $query = "
                DELETE
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_discussions']."
                WHERE
                forum_discussion_id=".$_GET["forum_discussion_id"]."
                ";
                
                $inicrond_db->Execute($query);
                
                $query = "
                DELETE
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_moderators']."
                WHERE
                forum_discussion_id=".$_GET["forum_discussion_id"]."
                ";
                
                $inicrond_db->Execute($query);
                
                $query = "
                DELETE
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_view']."
                WHERE
                forum_discussion_id=".$_GET["forum_discussion_id"]."
                ";
                
                $inicrond_db->Execute($query);
                
                $query = "
                DELETE
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_start']."
                WHERE
                forum_discussion_id=".$_GET["forum_discussion_id"]."
                ";
                
                $inicrond_db->Execute($query);
                
                $query = "
                DELETE
                FROM
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['forums_groups_reply']."
                WHERE
                forum_discussion_id=".$_GET["forum_discussion_id"]."
                ";
                
                $inicrond_db->Execute($query);
                $query = "
                UPDATE
                
                ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['sebhtml_forum_sujets']."
                SET
                forum_discussion_id=".$_POST["forum_discussion_id"]."
                WHERE
                forum_discussion_id=".$_GET["forum_discussion_id"]."
                ";
                
                $inicrond_db->Execute($query);
                
                include __INICROND_INCLUDE_PATH__."includes/functions/js_redir.function.php";//javascript redirection
                js_redir("main_inc.php?&cours_id=$cours_id");
                //va aux ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['cours']."
	}
	
        
}

include __INICROND_INCLUDE_PATH__.'includes/kernel/post_modulation.php';
?>