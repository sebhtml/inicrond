<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : footer du site
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
			//nombre de requêtes
			//---------------
			
			/*
			$output .= $_LANG["txt_footer"]["queries"]." ".$_LANG["SQBD"][$_OPTIONS["sql_SGBD"]];
			$output .= " : ";
			//$total = 0;
			
			//$tableau = array();
			
			$queries = $mon_objet->stats();
			
			foreach ($queries as $key => $value)
			{
			//$tableau[] = array($key, $value);
			//$total += $value;
			$output .= "[ ".$value." ".$key." ]";
			}
			
			//$output .= $total." ".txt_mod_count["total"];
			//$tableau[] = array(txt_mod_count["total"], $total);
			
			$output .= "<br />";
			*/
			
			//
			
			
			$output .= bb2html($_OPTIONS["footer_txt"]);//le header
			
			
		$output .= "<p align=\"center\"><table bgcolor=\"#DDDDDD\"><tr><td><small>";
		
		
	$output .= $_LANG["txt_usr_time_decals"][$_SESSION["sebhtml"]["usr_time_decal"]]." ";
		
			
	
	 $output .= "<i>".$_OPTIONS["project_name"]." ".$_OPTIONS["project_version"]."</i> ".
			 "<a href=\"http://membres.lycos.fr/zs8\" target=\"_blank\"><b>sebhtml</b></a> " ; 
			
			 
			 //$output .= $_LANG["txt_footer"]["txt"] ; 
			
			/*
		
			$gm_timestamp = gmmktime();

$output .= $_LANG["txt_footer"]["php"]."  ".phpversion()." ";
//$output .= "<br />";
$fin = $gm_timestamp.microtime();
$delta = $fin - $debut;
$delta = substr($delta, 0, 6);
$output .= $delta." s"."<br />";
*/

$output .= retournerHref("?module_id=43&php_file=index.php", $_LANG["common"]["43"]);

/*
$grosseur = strlen($output);

$grosseur = strlen($grosseur) + $grosseur + 
strlen(" ".$_LANG["txt_footer"]["octets"]) + strlen("</small>");

$output .= $grosseur." ".$_LANG["txt_footer"]["octets"];
*/
	$output .= "</small></td></tr></table></p>"; //";
	
}

?>
