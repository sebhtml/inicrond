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


$sql = "
SELECT
forum_discussion_id
FROM
".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_sujets"]."
WHERE
forum_discussion_id=".$_GET["forum_discussion_id"]."
LIMIT 1
;";

$sql_result = $mon_objet->query($sql);

//$fetch_result = $mon_objet->fetch_assoc($sql_result);

$num_rows = $mon_objet->num_rows($sql_result);

$mon_objet->free_result($sql_result);

	if($num_rows == 0)//cette section contient aucune discussion
	{
	
	//$module_content .= $num_rows;//nombre de rows
	
	
	$sql = "
	DELETE
	FROM
	".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["sebhtml_forum_discussions"]."
	WHERE
	forum_discussion_id=".$_GET["forum_discussion_id"]."
	;";

	$sql_result = $mon_objet->query($sql);

	$module_content .= $_LANG["23"]["removed_forum"];//texte pour dire que la section a été enlever
	}
	else//elle contient des discussion encore
	{
	//$module_content .= $num_rows;//nombre de rows
		
	$module_content .= $_LANG["23"]["not_removed_forum"];//texte pour dire que la section a été enlever
	}

}
?>

