<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : classe de connexion database
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

if(isset($_OPTIONS["INCLUDED"]))
{

	class Array_printer
	{
	var $type;
	var $array_data;
	
	function SET_type($type)
	{
	$this->type = $type;
	}
	function SET_array_data($array_data)
	{
	$this->array_data = $array_data;
	}
	
function  OUTPUT()
{
	if($this->type == "printable")
	{
	$width = 600/7;
	$tableau = $this->array_data;
	$contenu = "";
	$contenu .= "<table border=\"1\" width=\"100%\" height=\"100%\"  cellpadding=\"5\" cellspacing=\"5\">";
	$count_tableau = count($tableau);
		for($i= 0 ; $i<$count_tableau ; $i++)
		{
		if($i == 0)
		{
		$contenu .= "<tr height=\"30\">";
		}
		else
		{
		$contenu .= "<tr>";
		}

			$count_tableau_i = count($tableau[$i]);
			
			//$td_class = ($i % 2) ? "ligne_paire" : "ligne_impaire";
			
			for($j= 0 ; $j<$count_tableau_i; $j++)
			{
			$contenu .= "<td width=\"$width\" align=\"left\" valign=\"top\">";
			$contenu .= $tableau[$i][$j] ;
			$contenu .= "</td>";
			}
		$contenu .= "</tr>";
		}
	$contenu .= "</table>";
	
	return $contenu;
	}

}

	}	
}

?>
