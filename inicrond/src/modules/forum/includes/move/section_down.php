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

//---------------
//Trouver le order_id de la section qui doit descendre.
//--------------
$sql = "SELECT order_id 
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]."
WHERE
forum_section_id=".$_GET["forum_section_id"]."
";

$r = $mon_objet->query($sql);
$f = $mon_objet->fetch_assoc($r);
$mon_objet->free_result($r);

$order_id_0 = $f["order_id"];
$forum_section_id_0 = $_GET["forum_section_id"];

//-----------------
//trouver la section qui est en bas de la courante
//-----------------
$sql = "SELECT forum_section_id , order_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]."
WHERE
order_id > $order_id_0
ORDER BY order_id ASC
;";

	$r = $mon_objet->query($sql);
	$f = $mon_objet->fetch_assoc($r);
	$mon_objet->free_result($r);
	
	if(isset($f["forum_section_id"]))//peut-il descendre encore ???
	{
	$order_id_1 = $f["order_id"];
	$forum_section_id_1 = $f["forum_section_id"];
	
	//-----------------
	//updates
	//------------------
	$sql = "UPDATE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]."
	SET
	order_id=$order_id_1
	WHERE
	forum_section_id=$forum_section_id_0
	;";
	$r = $mon_objet->query($sql);
	
	$sql = "UPDATE
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sections"]."
	SET
	order_id=$order_id_0
	WHERE
	forum_section_id=$forum_section_id_1
	;";
	$r = $mon_objet->query($sql);
	}
}
?>

