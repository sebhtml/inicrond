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

class Calib_curve
{
	var $data;//contient les s�ies de donn�s.
	var $debug;//variable de debuguage.
	
	function __construct()
	{
	}
	
	function set_data($data)
	{
		$this->debug = FALSE;//d�uguage
	
	
		//enl�e
		/*
		foreach($data)
		{
		
		}
		*/
		//
		//Mettre les donn�s dans l'odre...
		//
		
		foreach($data AS $key => $serie_de_donnees)
		{
			$abscisses = array_keys($serie_de_donnees);
			sort($abscisses);
			$new_data = array();
	
			foreach($abscisses AS $x_value)
			{
				$new_data[$x_value] = $serie_de_donnees[$x_value];
			}
	
			$data[$key] = $new_data;//meise des donn�s dans l'ordre...
	
		}
	
		$this->data = $data;
		
		if($this->debug)
		{
			//echo "babouin";
		
			//print_r($data);
		
			foreach($this->data AS $serial)
			{
				if($this->debug)//debugage
				{
					echo "<hr />";
					echo "S�ie de donn�s lors de l'initialisation. :<br />";
			
					echo nl2br(print_r($serial, TRUE));
			
			
					echo "<hr />";
				}//fin du debgugae
			}
		}//fin du debguage
	}
	
	function print_stat()
	{
		echo "data";
		print_r( $this->data);//donn�s.
		echo "<br />";	
	}
	
	function gd_graph()
	{
		if(!$this->debug )
		{
			header("Content-type: image/png");
		}
		
		$_IMAGE["width"] = 550;
		$_IMAGE["height"] = 400;
	
		$im = @imagecreate($_IMAGE["width"], $_IMAGE["height"])
 		  or die("Cannot Initialize new GD image stream");
		$background_color = imagecolorallocate($im, 230, 255, 230);
	
		$rectangle = imagecolorallocate($im, 12, 25, 26);
		$color_info = imagecolorallocate($im, 240, 245, 250);

		$data = $this->data;

		if($this->debug)
		{
			print_r($data);
			//die($data);
		}
	
		//exit();
		//trouver les extremum.

		$_COLORS[0] = imagecolorallocate($im, 255, 0, 0);
		$_COLORS[1] = imagecolorallocate($im, 0, 0, 255);

		foreach($data AS $key => $serial)
		{
			if($this->debug)//debugage
			{
				echo "<hr />";
				echo "S�ie de donn�s lors de la trouvaille des extremums. :<br />";
				
				echo nl2br(print_r($serial, TRUE));
				
				echo "<hr />";
			}//fin du debgugae
	
			//}//fin du debguage
			$X_s = array_keys($serial);
			
			//extremum en X
			
			if(!isset($MIN_X) ||//si le minimum n'est pas mis encore
			min($X_s) < $MIN_X)//ou bien si le minimum actuellement trouv�est inf�ieur
			{
				$MIN_X = min($X_s);
			}
			if(!isset($MAX_X) ||//si le maximum n'est pas mis encore
			max($X_s) > $MAX_X)//ou bien si le maximum est sup�ieur �celui en m�oire.
			{
				$MAX_X = max($X_s);
			}
			
			//extremum en Y
			if(!isset($MIN_Y) ||//si le minimum n'est pas mis encore
			min($serial) < $MIN_Y)//ou bien si le minimum actuellement trouv�est inf�ieur
			{
				$MIN_Y = min($serial);
			}
			
			if(!isset($MAX_Y) ||//si le minimum n'est pas mis encore
			max($serial) > $MAX_Y)//ou bien si le minimum actuellement trouv�est inf�ieur
			{
				$MAX_Y = max($serial);
			}
		}

		if($this->debug)
		{
			echo "MAX_Y = $MAX_Y<br />";
			echo "MIN_Y = $MIN_Y<br />";
			echo "MAX_X = $MAX_X<br />";
			echo "MIN_X = $MIN_X<br />";		
		}
		
		//	
		//convertion des donn�s en pixels...
		//
		
		$margin = 20;
		//$_IMAGE["real_width"] = $_IMAGE["width"]-2*$margin ;

		$etendu_X = abs($MAX_X)-abs($MIN_X);//etendu
		
		if($etendu_X == 0)
		{
			$etendu_X = 1 ;
		}

		$etendu_width = $_IMAGE["width"]-4*$margin ;
		$etendu_Y = abs($MAX_Y)-abs($MIN_Y);//etendu
		
		if($etendu_Y == 0)
		{
			$etendu_Y = 1 ;
		}

		$etendu_height = $_IMAGE["height"]-4*$margin ;
		
		if($this->debug)
		{
			echo "etendu_X = $etendu_X<br />";
			echo "etendu_width = $etendu_width<br />";
			echo "etendu_Y = $etendu_Y<br />";
			echo "etendu_height = $etendu_height<br />";	
		}
		//les axes...
		
		//le maximum Y
		imagestring($im, 12, 
			$margin,//x du texte
			$margin,//y du texte
			$MAX_Y,
			$rectangle);
		
		//le minimum Y
		imagestring($im, 12, 
			$margin,//x du texte
			$_IMAGE["height"]-2*$margin,//y du texte
			$MIN_Y,
			$rectangle);
		
			
		//le minimum X
		imagestring($im, 12, 
			2*$margin,//x du texte
			$_IMAGE["height"]-$margin,//y du texte
			$MIN_X,
			$rectangle);
			
		//le max X
		imagestring($im, 12, 
			$_IMAGE["width"]-4*$margin,//x du texte
	    	 $_IMAGE["height"]-$margin,//y du texte
	      	$MAX_X,
	       	$rectangle);
		
		foreach($this->data AS $key => $serial)//pour chaque s�ie de donn�s.
		{
			$keys = array_keys($serial);
			if($this->debug)//debugage
			{
				echo "<hr />";
				echo "S�ie de donn�s lors du changement en piXELS. :<br />";
				echo nl2br(print_r($serial, TRUE));
				echo "<hr />";
			}//fin du debgugae	
		
			$new_serial = array();//on le vide...
		
			foreach($keys AS $index => $x_var)//pour chaque points
			{
				$_X = ($x_var-$MIN_X)/$etendu_X*$etendu_width+2*$margin;
		
				$_Y = (1-($serial[$keys[$index]]-$MIN_Y)/$etendu_Y)*$etendu_height+2*$margin;
		
			$new_serial[$_X] = $_Y;
			}
			
			$data[$key] = $new_serial;
		}
	
		foreach($data AS $key => $serial)
		{
			$keys = array_keys($serial);
		
			if($this->debug)//debugage
			{
				echo "<hr />";
				echo "S�ie de donn�s lors du tra�ge :<br />";
				
				echo nl2br(print_r($serial, TRUE));
				
				
				echo "<hr />";
			}//fin du debgugae
		
			foreach($keys AS $index => $x_var)
			{
				if(isset($keys[$index+1]))//si on n'est pas au dernier droite.
				{
					imageline ( $im,
					$keys[$index],//X1 
					$serial[$keys[$index]],//Y1
					$keys[$index+1],//X2 
					$serial[$keys[$index+1]],//Y2
					$_COLORS[$key] //la couleur.
					) OR die("CANNOT TRACE A LINE");
				}
			}
		}
	
		imagepng($im);
		imagedestroy($im);	
	}
}	
/*
$test = new Loi_normal();

$data = array(1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3,2, 3,2, 3,2, 3,2, 3,2, 3,2, 3,2, 3,2, 3, 3);

$test->set_data($data);





$test->gd_graph();
*/
?>
