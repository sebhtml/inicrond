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

class Loi_normal
{
	var $data;//donn�s.
	var $nb_class;//nombre de classes
	var $mean;//moyenne
	var $nb_data;//nombre de donn�s.
	var $standard_dev;//�art type corrig�
	var $minimum;
	var $maximum;
	var $etendu;
	var $amplitude_class;
	var $Z;
	var $distrib;//la distribution.
	var $demi_width;
	var $debug;
	
	function __construct()
	{
	}
	
	function set_data($data)
	{
		$this->debug = FALSE;//d�uguage
		
		$this->data = $data;
		$this->set_nb_data();
		$this->set_nb_class();//applique le nombre de classes.
		
		$this->set_mean();
		$this->set_standard_dev();
		
		$this->set_Z();
		$this->set_minimum();
		$this->set_maximum();
		
		$this->set_etendu();
			
		$this->set_amplitude_class();
		
		$this->set_distrib();
	}
	
	function set_nb_class()
	{
		
		//table de Sturges
		
		$rows = array();
		
		$rows[0]["min"] =10;
		$rows[0]["max"] = 22;
		$rows[0]["nb_class"] = 5;
		
		$rows[1]["min"] =23;
		$rows[1]["max"] = 44;
		$rows[1]["nb_class"] = 6;
		
		$rows[2]["min"] =45;
		$rows[2]["max"] = 90;
		$rows[2]["nb_class"] = 7;
		
		$rows[3]["min"] = 91;
		$rows[3]["max"] = 180;
		$rows[3]["nb_class"] = 8;
		
		$rows[4]["min"] = 181;
		$rows[4]["max"] = 360;
		$rows[4]["nb_class"] = 9;
		
		$rows[5]["min"] =361;
		$rows[5]["max"] = 720;
		$rows[5]["nb_class"] = 10 ;
	
	
		if($this->nb_data < 10)//trop petit
		{
			$this->nb_class = 5;
		}
		elseif($this->nb_data > 720)
		{
			$this->nb_class = 10;
		}
		else
		{
			foreach($rows AS $key => $value)
			{
				if($this->nb_data >= $value["min"] && $this->nb_data <= $value["max"])
				{
					$this->nb_class = $value["nb_class"];
				}
			}
		}	
	}
	
	function set_mean()
	{
	
		$sum_x = 0;
	
		foreach($this->data AS $key => $value)
		{
			$sum_x += $value;
		}
		
		$this->mean = $sum_x/$this->nb_data;
	}
	
	function set_nb_data()
	{
		$this->nb_data = count($this->data);
	}
	
	function set_standard_dev()
	{
	
		$sum_dist_2 = 0;
	
		foreach($this->data AS $key => $value)
		{
			$sum_dist_2 += pow( ($value - $this->mean), 2);
		}
		
		$this->standard_dev = pow(($sum_dist_2/($this->nb_data-1)), (1/2));
	}
	
	function print_stat()
	{
		echo "data";
		print_r( $this->data);//donn�s.
		echo "<br />";
		
		echo "distrib";
		echo nl2br(print_r( $this->distrib, TRUE));//donn�s.
		echo "<br />";
		
		echo "nb_class";
		echo $this->nb_class;//nombre de classes
		echo "<br />";
		
		echo "amplitude_class";
		echo $this->amplitude_class;//moyenne
		echo "<br />";
		
		echo "etendu";
		echo print_r($this->etendu);//moyenne
		echo "<br />";
		
		echo "mean";
		echo $this->mean;//moyenne
		echo "<br />";
		
		echo "nb_data";
		echo $this->nb_data;//nombre de donn�s.
		echo "<br />";
		
		echo "standard_dev";
		echo $this->standard_dev;//�art type corrig�
		echo "<br />";
	
	}
	
	function set_minimum()
	{
		$this->minimum["z"] = min($this->Z);
		$this->minimum["x"] = min($this->data);
	
	}
	function set_maximum()
	{
		$this->maximum["z"] = max($this->Z);
		$this->maximum["x"] = max($this->data);
	}
	
	function set_etendu()
	{
		$this->etendu["z"] = abs(($this->maximum["z"]) - ($this->minimum["z"]));
		$this->etendu["x"] = abs(($this->maximum["x"]) - ($this->minimum["x"]));
	}
		
	function set_amplitude_class()
	{
		$this->amplitude_class["z"] = $this->etendu["z"]/$this->nb_class;
		$this->amplitude_class["x"] = $this->etendu["x"]/$this->nb_class;
	}
	
	/*
	function set_demi_width()
	{
	$this->demi_width["z"] = (abs($this->minimum["z"]) > abs($this->maximum["z"])) ? $this->minimum["z"]: $this->maximum["z"];
	}
	*/
	function set_distrib()
	{
		$nb_class = $this->nb_class;
		$i= 0 ;
		while($nb_class--)
		{
			$distrib[$i]["z"]["min"] = $this->minimum["z"]+$i*$this->amplitude_class["z"];
			$distrib[$i]["z"]["max"] = $this->minimum["z"]+($i+1)*$this->amplitude_class["z"];
			
			$distrib[$i]["x"]["min"] = $this->minimum["x"]+$i*$this->amplitude_class["x"];
			$distrib[$i]["x"]["max"] = $this->minimum["x"]+($i+1)*$this->amplitude_class["x"];
			
			$distrib[$i]["percent"] = 0;
			
			$count = 0;
			
		
			foreach($this->Z AS $key => $value)
			{
			//echo $key.": <br />";
			
				//la premi�e classe
				if($nb_class == $this->nb_class && $value < $distrib[$i]["z"]["min"])
				{
					if($this->debug)
					{
						echo $distrib[$i]["z"]["min"]." <= ".$value." <= ".$distrib[$i]["z"]["max"]."<br />";
					}
					
					$count ++;
				}
				//les classes interm�iaires.
				elseif($value >= $distrib[$i]["z"]["min"] && $value < $distrib[$i]["z"]["max"])
				{
					if($this->debug)
					{
						echo $distrib[$i]["z"]["min"]." <= ".$value." < ".$distrib[$i]["z"]["max"]."<br />";
					}
					
					$count ++;
				}
				//la derni�e classe
				elseif($nb_class == 0  && $value >= $distrib[$i]["z"]["min"])
				{
					if($this->debug)
					{
						echo $distrib[$i]["z"]["min"]." <= ".$value." <= ".$distrib[$i]["z"]["max"]."<br />";
					}
					
					$count ++;
				}
			}
			
			$distrib[$i]["percent"] = $count/$this->nb_data;
			$i++;
		}
	
		$this->distrib = $distrib;	
	}
	
	function set_Z()
	{
		foreach($this->data AS $key => $value)
		{
			$this->Z[$key] = ($value-$this->mean)/$this->standard_dev;
		}
	}
	
	function gd_graph()
	{
	
		if(!$this->debug)
		{
			header("Content-type: image/png");
		}
		
		$_IMAGE["width"] = 550;
		$_IMAGE["height"] = 400;
	
		$im = @imagecreate($_IMAGE["width"], $_IMAGE["height"]) or die("Cannot Initialize new GD image stream");
		$background_color = imagecolorallocate($im, 230, 255, 230);
	
		$rectangle = imagecolorallocate($im, 12, 25, 26);
		$color_info = imagecolorallocate($im, 240, 245, 250);
	
	     
		$nb_class = $this->nb_class;
		$margin = 30;
		$_IMAGE["real_width"] = $_IMAGE["width"]-2*$margin ;
	
		$etendu_cote_z = abs($this->minimum["z"])+abs($this->maximum["z"]);
	
		//$_IMAGE["real_height"] = $_IMAGE["height"] - $margin;
		$min_img = $_IMAGE["height"] - $margin;
	
		$center_of_img = ($_IMAGE["real_width"])*abs($this->minimum["z"])/(abs($this->minimum["z"])+abs($this->maximum["z"]))+$margin;
	
	
		
		//trouve le maximum en pourcentage.
		foreach($this->distrib AS $value)
		{
			$data []= $value["percent"];
		}
	
		$maximum_percent = 1.2*max($data);
	
		foreach($this->distrib AS $class)
		{	
			$_X["1"] = $class["z"]["min"]/$etendu_cote_z*$_IMAGE["real_width"]+$center_of_img;
			$_Y["1"] = (1 - $class["percent"]/$maximum_percent)*$min_img;
			
			$_X["2"] =  $class["z"]["max"]/$etendu_cote_z*$_IMAGE["real_width"]+$center_of_img;
			$_Y["2"] =  $min_img;
			
			/*
			settype($_X["1"], "integer");
			settype($_Y["1"], "integer");
			settype($_X["2"], "integer");
			settype($_Y["2"], "integer");
			*/
			if($this->debug)
			{
				echo "x1=".$_X["1"]."<br />";
				echo "y1=".$_Y["1"]."<br />";
				echo "x2=".$_X["2"]."<br />";
				echo "y2=".$_Y["2"]."<br />";
			}
			else
			{
				imagefilledrectangle ( $im,
				$_X["1"]  ,//x1
				$_Y["1"]  ,//y1
				$_X["2"]  ,//x2
				$_Y["2"],//y2
				$rectangle);//couleur
	     
	    			$text_color = imagecolorallocate($im, 0, 0, 0);
	    
	    			//le pourcentage
	    			imagestring($im, 12, 
				$_X["1"]+2,//x du texte
				$_Y["1"]-30,//y du texte
				substr(100*$class["percent"], 0, 5)."%",
				$text_color);
				
					//le minimum
				imagestring($im, 12, 
				$_X["1"]-20,//x du texte
				$min_img+5,//y du texte
				substr($class["x"]["min"], 0, 5),
				$text_color);
				
				//le maximum
				imagestring($im, 12, 
				$_X["2"]-20,//x du texte
				$min_img+5,//y du texte
				substr($class["x"]["max"], 0, 5),
				$text_color);				
	  		}
	  	}
	
		if($this->debug)
		{
			$this->print_stat();
		}
	     
		//imagefilledrectangle ( $im, 0 , 0, 50 ,50, $yellow);
		/*
		$text_color = imagecolorallocate($im, 233, 14, 91);
		imagestring($im, 1, 5, 5,  "A Simple Text String", $text_color);
		*/
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
