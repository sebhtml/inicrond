<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//

//
//
//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond

Copyright (C) 2004  Sebastien Boisvert

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

//
//---------------------------------------------------------------------
*/
if(!__INICROND_INCLUDED__)
{
die("hacking attempt!!");
}
/**
 * return the mean
 *
 * @param        array  $population     all the individuals
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function moyenne($population)
{
	if(count($population) == 0)
	{
	return 0;
	}
$somme = 0;
$nombre = 0;
	foreach($population as $value)
	{
	$somme += $value;

	}
return $somme/count($population);
}
/**
 * return the corrected standard deviation
 *
 * @param        array  $population     all the individuals
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function ecart_type_corrige($population)
{
	if(count($population) <= 1)
	{
	return 0;
	}
	
$moyenne = moyenne($population);

$somme = 0;
$nombre = 0;
	foreach($population as $value)
	{
	$somme += pow($value - $moyenne, 2); //p.45 dans le livre
	$nombre++;
	}
$output = $somme/($nombre-1);

$output = pow($output, 1/2);//racie carr�
return $output;
}
/**
 * return the sum of the Xs
 *
 * @param        array  $population     all the individuals
 * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
 * @version      1.0.0
 */
function somme_x($population)
{


$somme = 0;

	foreach($population as $value)
	{
	$somme += $value; 

	}
return $somme;
}

?>
