<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : 
start thread
edit mesg
repley
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : inicrond
//
//---------------------------------------------------------------------



http://www.gnu.org/copyleft/gpl.html

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


*/
include "modules/forum/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}
elseif(isset($_SESSION["sebhtml"]["usr_id"]))
{
	if(isset($_GET["forum_sujet_id"]) AND
	$_GET["forum_sujet_id"] != "" AND
	(int) $_GET["forum_sujet_id"] AND
	
	isset($_SESSION["sebhtml"]["usr_id"]) AND
	peut_il_replier($_SESSION["sebhtml"]["usr_id"], $_GET["forum_sujet_id"], $mon_objet)//peut-il replier.
	)//peut-il replier ?
	//ajouter (reply)
	{

include "modules/forum/includes/start_edit_reply/reply.php";

	}
	elseif(isset($_GET["forum_message_id"]) AND
	$_GET["forum_message_id"] != "" AND
	(int) $_GET["forum_message_id"]
	)//éditer
	{
include "modules/forum/includes/start_edit_reply/edit.php";
	}
	else if(isset($_GET["forum_discussion_id"]) AND
	$_GET["forum_discussion_id"] != "" AND
	(int) $_GET["forum_discussion_id"]
	)//start thread
	{
include "modules/forum/includes/start_edit_reply/start.php";	
	}
}

?>

