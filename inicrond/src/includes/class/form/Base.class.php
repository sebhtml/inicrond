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

	class Base
	{
	
	var $text;
	var $form_o;
	
	var $name;
	var $value;
					
		function get_text()
		{
		return $this->text;
		}
		
		function get_form_o()
		{
		return $this->form_o;
		}
		function set_text($text)
		{
		$this->text = $text;
		}
		function set_name($name)
		{
		$this->name = $name;
		}
		function set_value($value)
		{
		$this->value = $value;
		}
	
	}
}

?>
