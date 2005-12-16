<?php
/*
    $Id$

    Inicrond : Network of Interactive Courses Registred On a Net Domain
    Copyright (C) 2004, 2005  Sébastien Boisvert

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
/*
Changes :

december 15, 2005
	I formated the code correctly.
	
		--sebhtml

*/


	
class Select_with_sql
{
	var $sql;//requeete
	var $name;//nom de la liste d�oulante
	var $default_VALUE;//valeur par d�aut
	var $text;//le txte �c��                var $inicrond_db;//le lien vers la base de donn�s.

	function OUTPUT()
	{
		$inicrond_db = $this->inicrond_db;
	
		$select = new Select();
		$select->set_name($this->name);
		$select->set_text($this->text);
		
		//$queries["SELECT"] ++; // comptage
			
		$rs = $inicrond_db->Execute($this->sql);
		while ($fetch_result = $rs->FetchRow())
		{
			$my_option = new Option();
			
			$my_option->set_value($fetch_result["VALUE"]);
			$my_option->set_text($fetch_result["TEXT"]);
			
			if($fetch_result["VALUE"] == $this->default_VALUE)
			{
				$my_option->selected();//SELECTED
			}
			
			$select->add_option($my_option);			
		}		
		
		$select->validate();
		
		return $select;		
	}	
}

?>