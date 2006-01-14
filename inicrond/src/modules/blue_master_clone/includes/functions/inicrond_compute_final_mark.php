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

function inicrond_compute_final_mark($usr_id, $group_id)
{
    global $_OPTIONS, $inicrond_db, $_RUN_TIME, $final_mark_formula, $final_mark_formula_value;

    if(!isset($usr_id) OR !isset($group_id))
    {
        echo "usr_id = $usr_id & group_id = $group_id <br />";
        //return NULL;
    }

    if(!isset($final_mark_formula_value))
    {
        //get the formula algorithm index.
        $query = "
        SELECT
        final_mark_formula
        FROM
        ".$_OPTIONS['table_prefix'].$_OPTIONS['tables']['groups']."
        WHERE
        group_id=$group_id
        ";

        $rs = $inicrond_db->Execute($query);
        $fetch_result = $rs->FetchRow();
        $final_mark_formula_value = $fetch_result['final_mark_formula'];
    }

    //get the plugin for the calculus.
    require "includes/final_mark_formula/".$final_mark_formula[$final_mark_formula_value].".php";//algorithm.

    if($points_max != 0)
    {
        return  array
        (
            'points_obtenus' => $point_obtenus,
            'points_max' => $points_max,
            'percentage' => $point_obtenus/$points_max*100
        );
    }

    else//point max is equal to 0.
    {
        return false;
    }
}

?>