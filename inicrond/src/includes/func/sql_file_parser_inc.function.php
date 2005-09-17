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
//Fonction du fichier : traiter des fichier sql
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
function sql_parser_remove_remarks($sql)
{
//explose les lignes
$file_rows = explode("\n", $sql);

//économise la memoire
$sql = "";

//compte les lignes
$nb_rows = count($file_rows);

	//boucle chaque ligne
	for($i=0;$i<$nb_rows;$i++)
	{
		//si le premier charactère est #...
		if($file_rows[$i][0] == "#")
		{
		//on l'élimine
		$sql .= "";
		}
		//sinon...
		else
		{
		//on ajoute la ligne
		$sql .= $file_rows[$i];
		}
	}
//retourne la requete sans les remarks
return $sql ;
}

function count_unescaped_single_quotes($string)
{
//we dont care about the matches
$matches = array();

//compter les ' total
$nb_single_quote = preg_match_all("/'/", $string, $matches);

//save memory
$matches = array();
	
//compter les escaped quotes avec une expression bizarre
//cette expression a été prise dans un ifichier phpBB
$nb_escaped_single_quote = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $string, $matches);

//save memory
$matches = array();
			
//unescaped quotes
return $nb_single_quote - $nb_escaped_single_quote ;
}

function sql_parser_split_queries($sql)
{
//split le fichier en pseudo query
$pseudo_queries = explode(";", $sql);

//compte les pseudo requètes
$nb_pseudo_queries = count($pseudo_queries);

$matches = array() ;
$sql = array();

	//boucle pour chaque pseudo query
	for($i=0;$i<$nb_pseudo_queries;$i++)
	{
		//pas de ligne vide ou la dernière
		if( (strlen($pseudo_queries[$i]) > 0) || ($i != $nb_pseudo_queries -1) )
		{
			$nb_unescaped_single_quote = count_unescaped_single_quotes($pseudo_queries[$i]);
		
			//if module 2 alors ça marche
			if(($nb_unescaped_single_quote % 2) == 0)
			{
			//ajoute la query
			$sql[] = $pseudo_queries[$i].";";
			}
			else
			{
			//add what we got to the next
			$pseudo_queries[$i+1] = $pseudo_queries[$i].";".$pseudo_queries[$i+1];
			}
			//sauve de la memoire
			$pseudo_queries[$i] = "";
		}
		
	}
	//retourne le tableau des requetes
return $sql;
}
?>


