<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."!
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : xoool
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
//-------------------

//--------------------
include "modules/wiki/includes/lang/".$_SESSION["sebhtml"]["usr_communication_language"]."/lang.php";
if(isset($_OPTIONS["INCLUDED"]))
{
$module_content = "";


if(!isset($_GET["wiki_title"]) OR
$_GET["wiki_title"] == "" 
)
{
$_GET["wiki_title"] = "index";

}


function wiki_exists($wiki_title, $mon_objet)
{
global $_OPTIONS;

$sql = "
SELECT
wiki_id

FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
WHERE
wiki_title='".$wiki_title."'

;";

//die("22");
$query_result = $mon_objet->query($sql);
$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);
/*
print_r($fetch_result);
exit();
*/
return isset($fetch_result["wiki_id"]);
	

}

	if(!wiki_exists(htmlEntities($_GET["wiki_title"]), $mon_objet) AND
	isset($_SESSION["sebhtml"]["usr_id"])
	)//crï¿½tion
	{
	$gmmktime = gmmktime();
	$sql = "
INSERT
INTO
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
(
usr_id,
wiki_title ,
wiki_content ,
wiki_ts ,
last_ts
)
VALUES
(
".$_SESSION["sebhtml"]["usr_id"].",


'".htmlEntities($_GET["wiki_title"])."',

'',

".$gmmktime.",
".$gmmktime."
)
;";

$query_result = $mon_objet->query($sql);

//die("22");

	}
	elseif(!wiki_exists(htmlEntities($_GET["wiki_title"]), $mon_objet) AND !isset($_SESSION["sebhtml"]["usr_id"]))//pas d'ï¿½ition pour les visiteurs.
	{
	$_GET["wiki_title"] = "index";
	}
	//accï¿½...
	if(isset($_GET["wiki_title"]) AND
	$_GET["wiki_title"] != "" AND
	isset($_GET["edit"] ) AND
	$_GET["edit"] == "yes" AND
	isset($_SESSION["sebhtml"]["usr_id"])
	)//ï¿½ition.
	{
		if(isset($_POST["new_wiki"]))
		{
		$sql = "
INSERT
INTO
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
(

usr_id,
wiki_title ,
wiki_content ,
wiki_ts,
last_ts
)
VALUES
(
".$_SESSION["sebhtml"]["usr_id"].",


'".htmlEntities($_GET["wiki_title"])."',

'".filter($_POST["wiki_content"])."',

".gmmktime().",
".gmmktime()."
)
;";


$query_result = $mon_objet->query($sql);

echo js_redir("?module_id=37&wiki_title=".stripslashes($_GET["wiki_title"]));
exit();
		}
		else
		{
      	$sql = "
SELECT
wiki_title ,
wiki_content
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
WHERE
wiki_title='".htmlEntities($_GET["wiki_title"])."'
ORDER BY wiki_ts DESC
;";

$query_result = $mon_objet->query($sql);

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);


$elements_titre = array(
retournerHref("?module_id=37", $_LANG["37"]["titre"]),
retournerHref("?module_id=37&wiki_title=".$fetch_result["wiki_title"], $fetch_result["wiki_title"]),
$_LANG["common"]["edit"]
);

// titre
$module_title = retourner_titre($elements_titre);


include "modules/wiki/includes/forms/content_inc.form.php";

		}//fin du formulaire.
	}
	//-----------
	//Changer la version.
	//-----------------
	elseif(isset($_GET["wiki_title"]) AND
	$_GET["wiki_title"] != "" AND
	isset($_GET["version"] ) AND
	$_GET["version"] == "yes" AND
	isset($_SESSION["sebhtml"]["usr_id"])
	)
	{
	
	      	$sql = "
SELECT
wiki_title 
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
WHERE
wiki_title='".htmlEntities($_GET["wiki_title"])."'
ORDER BY wiki_ts DESC
;";

$query_result = $mon_objet->query($sql);
$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);


$elements_titre = array(
retournerHref("?module_id=37", $_LANG["37"]["titre"]),
retournerHref("?module_id=37&wiki_title=".$fetch_result["wiki_title"], $fetch_result["wiki_title"]),
$_LANG["37"]["version"]
);

// titre
$module_title = retourner_titre($elements_titre);



		if(isset($_POST["version"]))
		{
		
	$sql = "
UPDATE 
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
SET
last_ts=".gmmktime()."
WHERE
wiki_id='".$_POST["wiki_id"]."'

;";

//die(nl2br($sql));
$query_result = $mon_objet->query($sql);

echo js_redir("?module_id=37&wiki_title=".stripSlashes($_GET["wiki_title"]));
exit();

		}
		else
		{
		
	$sql = "
SELECT
wiki_title ,
wiki_content
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
WHERE
wiki_title='".htmlEntities($_GET["wiki_title"])."'
ORDER BY wiki_ts DESC
;";


$query_result = $mon_objet->query($sql);

$fetch_result = $mon_objet->fetch_assoc($query_result);

$mon_objet->free_result($query_result);

//----------
//Forumulaire
//-------------

//

 $module_content .= $fetch_result["wiki_title"];
 
 //--------------
 //le last ts du desnier actuel.
 //---------------
 
	$sql = "
SELECT
last_ts
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
WHERE
wiki_title='".htmlEntities($_GET["wiki_title"])."'
ORDER BY last_ts DESC
;";


$query_result = $mon_objet->query($sql);
$fetch_result = $mon_objet->fetch_assoc($query_result);
$mon_objet->free_result($query_result);
$last_ts = $fetch_result["last_ts"];//pour tantôt, c'est pour savoir la dernière version.

 //-----------
 //la liste dï¿½oulante des versions.
 //-------------
 
	$sql = "
SELECT
wiki_id,
wiki_title,
wiki_ts,
last_ts,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"].".usr_id,
usr_name
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
WHERE
wiki_title='".htmlEntities($_GET["wiki_title"])."'
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"].".usr_id
ORDER BY wiki_ts DESC
;";


$query_result = $mon_objet->query($sql);

include "modules/wiki/includes/forms/version_inc.form.php";
		}
	}
	else//on montre la page.
	{
	
	if(isset($_GET["wiki_id"]) AND
	$_GET["wiki_id"] != "" AND
	(int) $_GET["wiki_id"]
	)
	{
	$sql = "
SELECT
wiki_id,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id,
usr_name,
wiki_title ,
wiki_content ,
wiki_ts 
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
WHERE
wiki_id='".$_GET["wiki_id"]."'
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"].".usr_id
;";
	}
	else
	{
	$sql = "
SELECT
wiki_id,
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id,
usr_name,
wiki_title ,
wiki_content ,
wiki_ts 
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"].", ".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"]."
WHERE
wiki_title='".htmlEntities($_GET["wiki_title"])."'
AND
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_usrs"].".usr_id=".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"].".usr_id
ORDER BY last_ts DESC
;";
	}
//die(htmlEntities($_GET["wiki_title"]));//debuguage

//die($sql);//debuguage;


$query_result = $mon_objet->query($sql);

$fetch_result = $mon_objet->fetch_assoc($query_result);

/*
if(!isset($fetch_result["wiki_title"]))//debuguage
{
die($sql);
}
*/

$mon_objet->free_result($query_result);

//
//TITRE
//

$elements_titre = array(
retournerHref("?module_id=37", $_LANG["37"]["titre"]),
$fetch_result["wiki_title"]
);

// titre
$module_title = retourner_titre($elements_titre);

$module_content .= $fetch_result["wiki_title"]."<br />";

if(isset($_SESSION["sebhtml"]["usr_id"]))
{
$module_content .= retournerHref("?module_id=37&wiki_title=".($fetch_result["wiki_title"])."&edit=yes",
 $_LANG["common"]["edit"])."<br />";
 $module_content .= retournerHref("?module_id=37&wiki_title=".$fetch_result["wiki_title"]."&version=yes",
 $_LANG["37"]["version"])."<br />";
}

$module_content .=

retournerHref("?module_id=4&usr_id=".$fetch_result["usr_id"],
$fetch_result["usr_name"])."<br />".
 format_time_stamp($fetch_result["wiki_ts"],
	 $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]).
bb2html($fetch_result["wiki_content"], "");


/*
 format_time_stamp($fetch_result["forum_message_add_gmt_timestamp"],
	 $_SESSION["sebhtml"]["usr_time_decal"], 
$_LANG["txt_usr_time_decals"], $_LANG["months"], $_LANG["week_days"]);
*/
	}
}
?>
