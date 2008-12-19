<?php
/*
    $Id: Textarea.class.php 72 2005-12-16 02:08:23Z sebhtml $

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

        
class Textarea extends Base
{
	var $rows;
	var $cols;
	var $style;
	
	/**
	* constructor
	*
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/
	function Textarea()
	{
		
	}
	
	/**
	* setter
	*
	* @param        integer  $rows  number of rows
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/		
	function set_rows($rows)
	{
		$this->rows = $rows;
	}
	
	/**
	* setter
	*
	* @param        integer  $cols  number of columns
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/
	function set_cols($cols)
	{
		$this->cols = $cols;
	}
	
	/**
	* validate the form object
	*
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/
	function validate()
	{
		$this->form_o = 
		"<textarea rows=\"".$this->rows."\" style=\"".$this->style."\"  name=\"".$this->name."\" id=\"".$this->name."\"";
		
		if($this->cols != "")
		{
			$this->form_o .= " cols=\"".$this->cols."\" ";
			
		}
		
		$this->form_o .=" >".$this->value."</textarea>";
		
	}
}


?>