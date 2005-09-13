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
//Fonction du fichier : traiter des tavbleau en 2D
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
/*
* $contenu .= un tableau en 2 dimensions
*/

function  retournerTableauXY($tableau, $largeur = "", $align = "left")
{
$contenu = "";
$contenu .= "<table border=\"0\" width=\"$largeur\" cellpadding=\"2\" cellspacing=\"2\">";
$count_tableau = count($tableau);
	for($i= 0 ; $i<$count_tableau ; $i++)
	{
	$contenu .= "<tr>";
		$count_tableau_i = count($tableau[$i]);
		
		$td_class = ($i % 2) ? "ligne_paire" : "ligne_impaire";
		
		for($j= 0 ; $j<$count_tableau_i; $j++)
		{
		$contenu .= "<td class=\"$td_class\" align=\"$align\">";
		$contenu .= $tableau[$i][$j] ;
		$contenu .= "</td>";
		}
	$contenu .= "</tr>";
	}
$contenu .= "</table>";

return $contenu;
}

function  echoTableauXY($tableau, $largeur = "")
{
echo retournerTableauXY($tableau, $largeur );
}

function unhtmlentities($chaineHtml) 
		{
			$tmp = get_html_translation_table(HTML_ENTITIES);
			$tmp = array_flip ($tmp);
			$chaineTmp = strtr ($chaineHtml, $tmp);
		
			return $chaineTmp;
		}
		
?>
