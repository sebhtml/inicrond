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
//Fonction du fichier : fonction pour les titres
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




//change le titre
function retourner_titre($elements_titre, $separateur = "", $titreSite = "")
{
global $_OPTIONS;


$count_elements_titre = count($elements_titre);

$i = 0;

$titre = "<a href=\".\" target=\"_top\">".$_OPTIONS["titre"]."</a>".$_OPTIONS["separator"];

	foreach($elements_titre as $value)
	{
		$titre .= $value;
		if($i != ($count_elements_titre - 1))
		{
		$titre .= $_OPTIONS["separator"];
		}
	$i ++;
	
	}



return $titre;


}

?>
