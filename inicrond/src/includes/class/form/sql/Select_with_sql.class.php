<?php
//$Id$

/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : voir discussion
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
	
	
	class Select_with_sql
	{
	var $sql;//requeete
	var $name;//nom de la liste déroulante
	var $default_VALUE;//valeur par défaut
	var $text;//le txte à côté
	var $mon_objet;//le lien vers la base de données.
	
		function SET_sql($sql)
		{
		$this->sql = $sql;
		}
		function SET_name($name)
		{
		$this->name = $name;
		}
		function SET_default_VALUE($default_VALUE)
		{
		$this->default_VALUE = $default_VALUE;
		}
		function SET_text($text)
		{
		$this->text = $text;
		}
		
		function SET_mon_objet($mon_objet)
		{
		$this->mon_objet = $mon_objet;
		}
		
		function OUTPUT()
		{


		
		
		$select = new Select();
		$select->set_name($this->name);
		$select->set_text($this->text);

		
		//$queries["SELECT"] ++; // comptage
			
		

		$query_result = $this->mon_objet->query($this->sql);
		while($fetch_result = $this->mon_objet->fetch_assoc($query_result))
		{
		$my_option = new Option();

$my_option->set_value($fetch_result["VALUE"]);
$my_option->set_text($fetch_result["TEXT"]);

	if($fetch_result["VALUE"] == $this->default_VALUE
		)
		{
$my_option->selected();//SELECTED
		}
		
$select->add_option($my_option);
	
		}

		$this->mon_objet->free_result($query_result);
		
		$select->validate();
		
		return $select;
		
		   
		   
		}
			
	}
	
}


?>