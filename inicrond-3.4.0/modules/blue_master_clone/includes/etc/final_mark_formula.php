<?php
/*---------------------------------------------------------------------

$Id: final_mark_formula.php 8 2005-09-13 17:44:21Z sebhtml $

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

$final_mark_formula = array(
"0" => 'cumulative_without_final_check',
"1" => 'each_final_greater_60_else_cumulative',//,
"2" => 'sum_of_final_greater_60_else_55',
"3" => 'sum_of_final_greater_60_else_55_on_100'
);

?>