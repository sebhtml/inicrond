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

	class Select extends Base
	{
	
	var $tableau;
	
		function Select()
		{
		$this->tableau = array();
		}
		
		function add_option($option)
		{
		$this->tableau []= array($option->get_text(), $option->get_value(), $option->get_selected());
		}
		
		function validate()
		{
		$this->form_o = "<select name=\"".$this->name."\">";
			foreach($this->tableau AS $objet)
			{
			$this->form_o .= "<option ".$objet[2]." value=\"".$objet[1]."\">".$objet[0]."</option>";
			}
		$this->form_o .= "</select>";
		}
		
		
			
	}
}

?>
