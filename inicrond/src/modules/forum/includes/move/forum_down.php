<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : modétateurs pour discussions
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

if(isset($_OPTIONS["INCLUDED"])
)
{


//------------
//on trouve dans quelle section est la discussion demandée.
//----------





$sql = "
SELECT
forum_section_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
WHERE
forum_discussion_id=".$_GET["forum_discussion_id"].
"
;";

$sql_result = $mon_objet->query($sql);

$fetch_result = $mon_objet->fetch_assoc($sql_result);

$forum_section_id = $fetch_result["forum_section_id"];

//$num_rows = $mon_objet->num_rows($sql_result);

$mon_objet->free_result($sql_result);



$sql = "
SELECT
order_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
WHERE
forum_discussion_id=".$_GET["forum_discussion_id"].//celui qui est avant
"

;";


$sql_result = $mon_objet->query($sql);

$fetch_result = $mon_objet->fetch_assoc($sql_result);

$order_id_present = $fetch_result["order_id"];

//$num_rows = $mon_objet->num_rows($sql_result);

$mon_objet->free_result($sql_result);



$sql = "
SELECT
MIN(order_id)
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
WHERE
order_id>".$order_id_present.//celui qui est avant
"
AND
forum_section_id=".$forum_section_id."


;";


$sql_result = $mon_objet->query($sql);

$fetch_result = $mon_objet->fetch_assoc($sql_result);

$order_id_apres = $fetch_result["MIN(order_id)"];

//$num_rows = $mon_objet->num_rows($sql_result);

$mon_objet->free_result($sql_result);

	if(isset($fetch_result["MIN(order_id)"]))//est-ce qu'il y a quelque chose avant.
	{
	
	//on va chercher la discussion avant.
	$sql = "
	SELECT
	forum_discussion_id
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
	WHERE
	order_id=".$order_id_apres.//celui qui est avant
	"
	;";


	$sql_result = $mon_objet->query($sql);

	$fetch_result = $mon_objet->fetch_assoc($sql_result);

	$forum_discussion_id_apres = $fetch_result["forum_discussion_id"];

	//$num_rows = $mon_objet->num_rows($sql_result);

	$mon_objet->free_result($sql_result);


	
	
	
	
	$sql = //on met le order id du présent à celui avant.
	"
	UPDATE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
	SET
	order_id=".$order_id_apres."
	WHERE
	forum_discussion_id=".$_GET["forum_discussion_id"].//celui qui est avant
	"
	;";

	$sql_result = $mon_objet->query($sql);
	
	
	
	
	$sql = //celui qui est en haut descend
	"
	UPDATE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
	SET
	order_id=".$order_id_present."
	WHERE
	forum_discussion_id=".$forum_discussion_id_apres."
	
	;";

	$sql_result = $mon_objet->query($sql);
	}

}
?>

