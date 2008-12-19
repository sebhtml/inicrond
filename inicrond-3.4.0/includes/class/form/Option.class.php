<?php
/*
    $Id: Option.class.php 72 2005-12-16 02:08:23Z sebhtml $

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

class Option
{
	var $value;//the value that will be sent to server
	var $text;//the text
	var $selected;//selected, TRUE OR FALSE
	/**
	* getter
	*
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/						
	function get_text()
	{
		return $this->text;
	}
	
	/**
	* getter
	*
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/			
	function get_value()
	{
		return $this->value;
	}
	
	/**
	* getter
	*
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/	
	function get_selected()
	{
		return $this->selected;
	}
	
	/**
	* select the option
	*
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/	
	function selected()
	{
		$this->selected = "SELECTED";
	}
	
	/**
	* setter
	*
	* @param        string  $text  the text
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/	
	function set_text($text)
	{
		$this->text = $text;
	}
	
	/**
	* setter
	*
	* @param        string  $value  the value
	* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
	* @version      1.0.0
	*/	
	function set_value($value)
	{
		$this->value = $value;
	}
}


?>
