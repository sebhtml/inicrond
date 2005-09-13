<?php

/*---------------------------------------------------------------------

$Id$

sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

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
-----------------------------------------------------------------------*/

/**
* 
*
* @param        integer  $default_value    
* @author       Sebastien Boisvert sebhtml@users.sourceforge.net
* @version      1.0.0
*/	
function generate_time_drop_list($name, $default_value, $lang_str_for_zereo = 'no_cache')
{
        global $_LANG;
        
        
        $elements = array(2 ,4, 8, 16 ,32); 
        
        $multiplicators = array(
        'secs' => 1,
        'mins' => 60,
        'hours' => 60*60,
        'days' => 60*60*24,
        'weeks' => 60*60*24*7
        );
        
        $return = "<select name=\"$name\">";
        
        $number_of_secs = 0 ;
        
        $return .= "<option $selected value=\"$number_of_secs\">".$_LANG[$lang_str_for_zereo]." (0)</option>";
        
        $selected = $number_of_secs == $default_value ? "SELECTED" : "";
	foreach($multiplicators AS $key => $multiplicator)
	{
		foreach($elements AS $value)
		{
                        $number_of_secs = $value*$multiplicator ;
                        $selected = $number_of_secs == $default_value ? "SELECTED" : "";
                        
                        
                        $return .= "<option $selected value=\"$number_of_secs\">".$value." ".$_LANG[$key]." ($number_of_secs)</option>";
		}
	}
        $return .= "</select>";
        
        return $return;
        
}
?>