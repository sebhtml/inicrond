<?php
//$Id$


if(!isset($_OPTIONS["INCLUDED"]))
{
die("hacking attempt!!");
}

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : gérer l'Accès des membres sur le site
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : inicrond
//
//---------------------------------------------------------------------
*/

/*


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

function is_usr_in_group($usr_id, $group_id, $mon_objet)
{
global $_OPTIONS;

	if(!isset($_SESSION["sebhtml"]["usr_id"]))//pas de session
	{
	return FALSE;//faux!!!
	}//fin du if.

//global $mon_objet;

//$mon_objet = $this->SGBD_connexion;
/*
$mon_objet = new Connexion_db;

$mon_objet->set_SGBD("mysql");

$mon_objet-> connect($_OPTIONS["sql_server_name"], $_OPTIONS["sql_user_name"], $_OPTIONS["sql_user_password"], TRUE);

$mon_objet->select_db($_OPTIONS["sql_database_name"]);

*/
//global $queries ;

//

$query = "
SELECT count(usr_id)
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs
WHERE
usr_id=$usr_id
AND
group_id=$group_id
AND
usr_pending=0;";

	if(!$query_result = $mon_objet->query($query))
	{
	die($query." ".$mon_objet->error());
	}

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

	if($fetch_result["count(usr_id)"] == 1)
	{
	return TRUE;
	}
	else if($fetch_result["count(usr_id)"] == 0)
	{
	return FALSE;
	
	}
}


function is_usr_pending($usr_id, $group_id, $mon_objet)
{
global $_OPTIONS;
	if(!isset($_SESSION["sebhtml"]["usr_id"]))//pas de session
	{
	return FALSE;//faux!!!
	}//fin du if.

$query = "
SELECT count(usr_id)
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs
WHERE
usr_id=$usr_id
AND
group_id=$group_id
AND
usr_pending=1;";

	$query_result = $mon_objet->query($query);
	$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);

return $fetch_result["count(usr_id)"] == 1 ;
}

		


function is_leader($usr_id, $group_id, $mon_objet)
{
global $_OPTIONS;
	if(!isset($_SESSION["sebhtml"]["usr_id"]))//pas de session
	{
	return FALSE;//faux!!!
	}//fin du if
//global $mon_objet;

//

$query = "
SELECT count(usr_id)
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."
WHERE
usr_id=$usr_id
AND
group_id=$group_id
;";

	if(!$query_result = $mon_objet->query($query))
	{
	die($query." ".mysql_error());
	}

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

	if($fetch_result["count(usr_id)"] == 1)
	{
	return TRUE;
	}
	else if($fetch_result["count(usr_id)"] == 0)
	{
	return FALSE;
	
	}
}



function is_mod($usr_id, $forum_discussion_id, $mon_objet)
{
global $_OPTIONS;
	if(!isset($_SESSION["sebhtml"]["usr_id"]))//pas de session
	{
	return FALSE;//faux!!!
	}//fin du if
//global $mon_objet;

//

$query = "
SELECT 
count(".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups_usrs"].".usr_id)
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_moderators"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs
WHERE

forum_discussion_id=$forum_discussion_id
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_moderators"].".group_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs.group_id
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs.usr_id=$usr_id
;";

	if(!$query_result = $mon_objet->query($query))
	{
	die($query." ".mysql_error());
	}

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

	return ($fetch_result["count(".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs.usr_id)"] != 0);
}

function peut_il_replier($usr_id, $forum_sujet_id, $mon_objet)
{//ouverture de la fonction peut_il_replier
global $_OPTIONS;

	if(!isset($_SESSION["sebhtml"]["usr_id"]))//pas de session
	{
	return FALSE;//faux!!!
	}//fin du if
	
//--------------
//on vérifie le champs locked.
//-----------------

$query = "
SELECT 
locked
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
WHERE

forum_sujet_id=".$forum_sujet_id."

;";

	if(!$query_result = $mon_objet->query($query))
	{
	die($query." ".mysql_error());
	}

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

if($fetch_result["locked"] == 1)
{
return FALSE;

}//fin du if

$forum_discussion_id = sujet_2_discussion($forum_sujet_id, $mon_objet);

//global $mon_objet;

//

$query = "
SELECT 
right_thread_reply
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
WHERE

forum_discussion_id=$forum_discussion_id

;";

	if(!$query_result = $mon_objet->query($query))
	{
	die($query." ".mysql_error());
	}

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

	if($fetch_result["right_thread_reply"] == 0)//tout le monde
	{
	return TRUE;
	}
	elseif($fetch_result["right_thread_reply"] == -1)//auteur.
	{
		if($usr_id == thread_starter($forum_sujet_id, $mon_objet))//auteur.
		{
		return TRUE;
		}
		else
		{
		return FALSE;
		}
	}
	else//groupe quelconque.
	{
		return  is_usr_in_group($usr_id, $fetch_result["right_thread_reply"]);
	}
}//fermeture de la fonction peut_il_replier

function sujet_2_discussion($forum_sujet_id, $mon_objet)
{
global $_OPTIONS;

//global $mon_objet;

//

$query = "
SELECT 
forum_discussion_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
WHERE

forum_sujet_id=$forum_sujet_id

;";

	if(!$query_result = $mon_objet->query($query))
	{
	die($query." ".mysql_error());
	}

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

return $fetch_result["forum_discussion_id"];
}

function thread_starter($forum_sujet_id, $mon_objet)
{
//global $mon_objet;

global $_OPTIONS;
	//$queries["SELECT"] ++; // comptage	
	$query = "SELECT
	usr_id
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
	WHERE
	forum_sujet_id=$forum_sujet_id
	
	;";
	
	if(!$query_result = $mon_objet->query($query))
	{
	die($query." ".mysql_error());
	}

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

return $fetch_result["usr_id"];
	
}


function right_add_a_file($usr_id, $uploaded_files_section_id, $mon_objet)
{	
global $_OPTIONS;

	if(!isset($_SESSION["sebhtml"]["usr_id"]))//pas de session
	{
	return FALSE;//faux!!!
	}//fin du if
//global $mon_objet;

//

$query = "
SELECT right_add_a_file
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections
WHERE
uploaded_files_section_id=$uploaded_files_section_id
;";

	if(!$query_result = $mon_objet->query($query))
	{
	die($query." ".$mon_objet->error());
	}

$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);

	if($fetch_result["right_add_a_file"] == 0)//tous
	{
	return TRUE;
	}
	else
	{

	$query = "
	SELECT count(usr_id)
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_uploaded_files"]."_sections
	WHERE
	usr_id=$usr_id
	AND
	group_id=right_add_a_file
	AND
	uploaded_files_section_id=$uploaded_files_section_id
	;";

		if(!$query_result = $mon_objet->query($query))
		{
		die($query." ".mysql_error());
		}

	$fetch_result = $mon_objet->fetch_assoc($query_result);

	$mon_objet->free_result($query_result);

		if($fetch_result["count(usr_id)"] == 1)
		{
		return TRUE;
		}
		else if($fetch_result["count(usr_id)"] == 0)
		{
		return FALSE;

		}
	}
	
}

function group_name($group_id, $mon_objet)
	{
	
	global $_OPTIONS;
	
	$sql = 
		"SELECT
		group_name
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."
		WHERE
		group_id=$group_id
		;";
		if(!$query_result = $mon_objet->query($sql))
		{
		die($query." ".mysql_error());
		}

	$fetch_result = $mon_objet->fetch_assoc($query_result);

	$mon_objet->free_result($query_result);

	return $fetch_result["group_name"];
	}
	
function message2sujet($forum_message_id, $mon_objet)
{

global $_OPTIONS;

$sql = 
		"SELECT
		forum_sujet_id
		FROM
		".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_messages"]."
		WHERE
		forum_message_id=$forum_message_id
		;";
		$query_result = $mon_objet->query($sql);
		

	$fetch_result = $mon_objet->fetch_assoc($query_result);

	$mon_objet->free_result($query_result);

	return $fetch_result["forum_sujet_id"];

}


function right_add_an_img($usr_id, $galerie_id, $mon_objet)
{	
global $_OPTIONS;

if(!isset($_SESSION["sebhtml"]["usr_id"]))//pas de session
	{
	return FALSE;//faux!!!
	}//fin du if
//global $mon_objet;

//

$query = "
SELECT 
right_add_an_img
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
WHERE
galerie_id=$galerie_id
;";

$query_result = $mon_objet->query($query);
$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);

	if($fetch_result["right_add_an_img"] == 0)//tous
	{
	return TRUE;
	}
	else
	{

	$query = "
	SELECT 
	count(usr_id)
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_galeries"]."
	WHERE
	usr_id=$usr_id
	AND
	group_id=right_add_an_img
	AND
	galerie_id=$galerie_id
	;";

		$query_result = $mon_objet->query($query);
			$fetch_result = $mon_objet->fetch_assoc($query_result);
	$mon_objet->free_result($query_result);

		if($fetch_result["count(usr_id)"] == 1)
		{
		return TRUE;
		}
		else if($fetch_result["count(usr_id)"] == 0)
		{
		return FALSE;

		}
	}
	
}


function right_add_an_url($usr_id, $directory_section_id, $mon_objet)
{
global $_OPTIONS;
	
	if(!isset($_SESSION["sebhtml"]["usr_id"]))//pas de session
	{
	return FALSE;//faux!!!
	}//fin du if
//global $mon_objet;

//

$query = "
SELECT 
right_add_an_url
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]."
WHERE
directory_section_id=$directory_section_id
;";

$query_result = $mon_objet->query($query);
$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);

	if($fetch_result["right_add_an_url"] == 0)//tous
	{
	return TRUE;
	}
	else
	{

	$query = "
	SELECT 
	count(usr_id)
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_groups"]."_usrs, ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["directory_sections"]."
	WHERE
	usr_id=$usr_id
	AND
	group_id=right_add_an_url
	AND
directory_section_id=$directory_section_id
	;";

		$query_result = $mon_objet->query($query);
			$fetch_result = $mon_objet->fetch_assoc($query_result);
	$mon_objet->free_result($query_result);

		if($fetch_result["count(usr_id)"] == 1)
		{
		return TRUE;
		}
		else if($fetch_result["count(usr_id)"] == 0)
		{
		return FALSE;

		}
	}
	
}
?>
