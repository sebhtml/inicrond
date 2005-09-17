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

	class Search_layout
	{
	
	var $contenu;
	
		function Search_layout($queries, $_LANG, $mon_objet, $_OPTIONS)
		{
		
			//fichiers
			$this->contenu = "";
			
			
			$query_result = $mon_objet->query($queries[0]);
		
			$tableau = array();
			while($fetch_result = $mon_objet->fetch_assoc($query_result))
			{
				if(strlen($fetch_result["data2"]) > $_OPTIONS["max_len"])
				{
				$fetch_result["data2"] = substr($fetch_result["data2"], 0, $_OPTIONS["max_len"])."...";
				}
			$tableau [] = array(retournerHref("?module_id=6&uploaded_file_id=".
			$fetch_result["data1"], $fetch_result["data2"]));
			}
			
			$mon_objet->free_result($query_result);
			
			if(count($tableau) != 0)
			{
			$this->contenu .= "<b>".$_LANG["common"]["1"]."</b>" ." (".count($tableau).")";
		     $this->contenu .= retournerTableauXY($tableau);
			}
			
		     //forum
			$query_result = $mon_objet->query($queries[1]);
		
			$tableau = array();
			while($fetch_result = $mon_objet->fetch_assoc($query_result))
			{
			if(strlen($fetch_result["data2"]) > $_OPTIONS["max_len"])
			{
			$fetch_result["data3"] = substr($fetch_result["data2"], 0, $_OPTIONS["max_len"])."...";
			}
			
			$tableau [] = array(retournerHref("?module_id=25&forum_sujet_id=".
			$fetch_result["data1"]."#".
			$fetch_result["data2"]
			, $fetch_result["data3"]));
			}
			
			$mon_objet->free_result($query_result);
			if(count($tableau) != 0)
			{
			$this->contenu .= "<b>".$_LANG["common"]["23"]."</b>"." (".count($tableau).")";
		     $this->contenu .= retournerTableauXY($tableau);
			}
		
			//images
			
			$query_result = $mon_objet->query($queries[2]);
		
			$tableau = array();
			while($fetch_result = $mon_objet->fetch_assoc($query_result))
			{
			if(strlen($fetch_result["data2"]) > $_OPTIONS["max_len"])
				{
				$fetch_result["data2"] = substr($fetch_result["data2"], 0, $_OPTIONS["max_len"])."...";
				}
			$tableau [] = array(retournerHref("?module_id=13&image_id=".
			$fetch_result["data1"]
			, $fetch_result["data2"]));
			}
			
			$mon_objet->free_result($query_result);
			
			if(count($tableau) != 0)
			{
			$this->contenu .= "<b>".$_LANG["common"]["10"]."</b>"." (".count($tableau).")";
		     $this->contenu .= retournerTableauXY($tableau);
			}
			
			//".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."
			$query_result = $mon_objet->query($queries[3]);
		
			$tableau = array();
			while($fetch_result = $mon_objet->fetch_assoc($query_result))
			{
			if(strlen($fetch_result["data2"]) > $_OPTIONS["max_len"])
				{
				$fetch_result["data2"] = substr($fetch_result["data2"], 0, $_OPTIONS["max_len"])."...";
				}
			$tableau [] = array(retournerHref("?module_id=37&".$_OPTIONS["table_prefix"].$_OPTIONS["tables"]["wiki"]."_id=".
			$fetch_result["data1"]
			, $fetch_result["data2"]));
			}
			
			$mon_objet->free_result($query_result);
			
			if(count($tableau) != 0)
			{
			$this->contenu .= "<b>".$_LANG["common"]["37"]."</b>"." (".count($tableau).")";
		     $this->contenu .= retournerTableauXY($tableau);
			}
			
			//membres
			$query_result = $mon_objet->query($queries[4]);
		
			$tableau = array();
			while($fetch_result = $mon_objet->fetch_assoc($query_result))
			{
			if(strlen($fetch_result["data2"]) > $_OPTIONS["max_len"])
				{
				$fetch_result["data2"] = substr($fetch_result["data2"], 0, $_OPTIONS["max_len"])."...";
				}
			$tableau [] = array(retournerHref("?module_id=4&usr_id=".
			$fetch_result["data1"]
			, $fetch_result["data2"]));
			}
			
			$mon_objet->free_result($query_result);
			
			if(count($tableau) != 0)
			{
			$this->contenu .= "<b>".
$_LANG["common"]["8"]."</b>"." (".count($tableau).")";
		     $this->contenu .= retournerTableauXY($tableau);
			}
			
			//liens			
			
			$query_result = $mon_objet->query($queries[5]);
		
			$tableau = array();
			while($fetch_result = $mon_objet->fetch_assoc($query_result))
			{
			if(strlen($fetch_result["data2"]) > $_OPTIONS["max_len"])
				{
				$fetch_result["data2"] = substr($fetch_result["data2"], 0, $_OPTIONS["max_len"])."...";
				}
			$tableau [] = array(retournerHref("?module_id=42&link_id=".
			$fetch_result["data1"]
			, $fetch_result["data2"]));
			}
			
			$mon_objet->free_result($query_result);
			
			if(count($tableau) != 0)
			{
			$this->contenu .= "<b>".$_LANG["common"]["38"]."</b>"." (".count($tableau).")";
		     $this->contenu .= retournerTableauXY($tableau);
		    	}
			
		    $this->module_contenu = $this->contenu;
		    
		 }
		 function output()
		 {
		 return $this->module_contenu;
		 }
	}	
}

?>
