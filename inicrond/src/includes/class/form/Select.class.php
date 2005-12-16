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

class Select extends Base
{
	var $tableau;
	/**
	* constructor
	*
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/	
	function Select()
	{
		$this->tableau = array();
	}
	
	/**
	* add a option in the select
	*
	* @param        object  $option  an option for the select
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/		
	function add_option($option)
	{
		$this->tableau []= array($option->get_text(), $option->get_value(), $option->get_selected());
	}
	
	/**
	* validate the form object
	*
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/		
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


?>