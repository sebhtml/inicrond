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


function z_with_color($value)
{
    if(0 <= $value && $value < 1)
    {
        //$color = "brown";
        //$tag_type= "i";

        $span_class="z_0_to_1";
    }
    elseif(1 <= $value && $value < 2)
    {
        //$color = "blue";
        //$tag_type= "h3";

        $span_class="z_1_to_2";
    }
    elseif(2 <= $value && $value < 3)
    {
        //$color = "green";
        //$tag_type= "h2";

        $span_class="z_2_to_3";
    }
    elseif(3 <= $value)
    {
        //$color = "purple";
        //$tag_type= "h1";

        $span_class="z_bigger_than_3";
    }
    else
    {
        //$color = "red";
        //$tag_type= "i";

        $span_class="z_smaller_than_0";
    }

    if (!is_array ($value))
    {
        return "<span class=\"$span_class\">"."Z&nbsp;".substr($value, 0, 4)."</span";
    }
    else
    {
        return '?' ;
    }
}

?>