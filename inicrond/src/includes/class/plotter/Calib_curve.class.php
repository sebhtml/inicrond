<?php
//$Id$


/*
//---------------------------------------------------------------------
//0.0.0-20041128
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//
//---------------------------------------------------------------------
*/
/*



*/

class Calib_curve
{
	var $data;//contient les séries de données.
	var $debug;//variable de debuguage.
	
	function __construct()
	{
	}
	
	function set_data($data)
	{
	$this->debug = FALSE;//débuguage
	

	//enlève
	/*
	foreach($data)
	{
	
	}
	*/
	//
	//Mettre les données dans l'odre...
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
	$data[$key] = $new_data;//meise des données dans l'ordre...
	
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
		echo "Série de données lors de l'initialisation. :<br />";
		
		echo nl2br(print_r($serial, TRUE));
		
		
		echo "<hr />";
		}//fin du debgugae
		
		}
		
		
		
		
		}//fin du debguage
	}
	
	
	
	
	function print_stat()
	{
 	echo "data";
	print_r( $this->data);//données.
	echo "<br />";
	
	
	
	}
	
	
	function gd_graph()
	{
	
	
	/*
$data = array(
		array(
			"x" => "y",
			"x" => "y"
			
			),
		array(
			"x" => "y",
			"x" => "y"
			)
);
*/

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
		
		//echo "babouin";
		
		//print_r($data);
		
		
		if($this->debug)//debugage
		{
		echo "<hr />";
		echo "Série de données lors de la trouvaille des extremums. :<br />";
		
		echo nl2br(print_r($serial, TRUE));
		
		
		echo "<hr />";
		}//fin du debgugae
		
		
		
		
		
		
		//}//fin du debguage
		$X_s = array_keys($serial);
		
		//extremum en X
		
		if(!isset($MIN_X) OR//si le minimum n'est pas mis encore
		min($X_s) < $MIN_X)//ou bien si le minimum actuellement trouvé est inférieur
		{
		$MIN_X = min($X_s);
		}
		if(!isset($MAX_X) OR//si le maximum n'est pas mis encore
		max($X_s) > $MAX_X)//ou bien si le maximum est supérieur à celui en mémoire.
		{
		$MAX_X = max($X_s);
		}
		
		//extremum en Y
		if(!isset($MIN_Y) OR//si le minimum n'est pas mis encore
		min($serial) < $MIN_Y)//ou bien si le minimum actuellement trouvé est inférieur
		{
		$MIN_Y = min($serial);
		}
		
		if(!isset($MAX_Y) OR//si le minimum n'est pas mis encore
		max($serial) > $MAX_Y)//ou bien si le minimum actuellement trouvé est inférieur
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
//convertion des données en pixels...
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
	/*       
if($this->debug)
		{
		echo nl2br(print_r($this->data, TRUE));
		
		}
		*/
		
foreach($this->data AS $key => $serial)//pour chaque série de données.
	{
			$keys = array_keys($serial);
		if($this->debug)//debugage
		{
		echo "<hr />";
		echo "Série de données lors du changement en piXELS. :<br />";
		
		echo nl2br(print_r($serial, TRUE));
		
		
		echo "<hr />";
		}//fin du debgugae	
		
		$new_serial = array();//on le vide...
		
		foreach($keys AS $index => $x_var)//pour chaque points
		{
		$_X = ($x_var-$MIN_X)/$etendu_X*$etendu_width+2*$margin;
		
		$_Y = (1-($serial[$keys[$index]]-$MIN_Y)/$etendu_Y)*$etendu_height+2*$margin;
		
		/*if($this->debug)
		{
		echo nl2br(print_r($serial, TRUE));
		
		}*/
		
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
		echo "Série de données lors du traçage :<br />";
		
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
	//
	//titre...
	//
	/*
	imagefilledrectangle ( $im,
	10  ,//x1
	 10  ,//y1
	  $_IMAGE["width"]-10  ,//x2
	  50,//y2
	     $rectangle);//couleur
	   
	      imagestring($im, 12, 
	    20,//x du texte
	     25,//y du texte
	      "Distribution",
	       $color_info);
	       
	       imagestring($im, 12, 
	    170,//x du texte
	     30,//y du texte
	      "sebhtml@yahoo.ca",
	       $color_info);
	       
	       imagestring($im, 12, 
	    250,//x du texte
	     15,//y du texte
	      "loi_normal-0.0.0-20041128",
	       $color_info);
	       */
	     
	//$nb_class = $this->nb_class;
	
	
	//$etendu_cote_z = abs($this->minimum["z"])+abs($this->maximum["z"]);
	
	//$_IMAGE["real_height"] = $_IMAGE["height"] - $margin;
	//$min_img = $_IMAGE["height"] - $margin;
	
	
	
	//$max_img = $_IMAGE["height"] + $margin;
	
	//$center_of_img = ($_IMAGE["real_width"])*abs($this->minimum["z"])/(abs($this->minimum["z"])+abs($this->maximum["z"]))+$margin;
	
	
	/*
	 imagestring($im, 12, 
	    250,//x du texte
	     15,//y du texte
	      $center_of_img,
	       $rectangle);
	       
	        imagefilledrectangle ( $im,
	$center_of_img  ,//x1
	 3  ,//y1
	  $center_of_img  ,//x2
	   4,//y2
	     $rectangle);//couleur
	     */
	/*
	$_X["min"] = $margin;
	$_X["max"] = $_IMAGE["width"] - ($this->maximum["z"]-abs($this->minimum["z"]))/$this->etendu["z"]*$_IMAGE["width"];
	
	}	
	$_Y["min"] = $margin+100;
	$_Y["max"] = $_IMAGE["height"] -$margin-20;
	*/
	/*
	if($this->debug)
	{
	echo "x_min=".$_X["min"]."<br />";
	echo "x_max=".$_X["max"]."<br />";
	}
	*/
	/*
	//trouve le maximum en pourcentage.
	foreach($this->distrib AS $value)
	{
	$data []= $value["percent"];
	}
	
	$maximum_percent = 1.2*max($data);
	*/
	/*
	foreach($this->distrib AS $class)
	//while($nb_class)
	{
		
	
	$_X["1"] = $class["z"]["min"]/$etendu_cote_z*$_IMAGE["real_width"]+$center_of_img;
	$_Y["1"] = (1 - $class["percent"]/$maximum_percent)*$min_img;
	
	$_X["2"] =  $class["z"]["max"]/$etendu_cote_z*$_IMAGE["real_width"]+$center_of_img;
	$_Y["2"] =  $min_img;
	*/
	/*
	settype($_X["1"], "integer");
	settype($_Y["1"], "integer");
	settype($_X["2"], "integer");
	settype($_Y["2"], "integer");
	*/
	/*
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
	     $_X["1"]-10,//x du texte
	     $min_img+5,//y du texte
	      substr($class["x"]["min"], 0, 5),
	       $text_color);
	       
	       //le maximum
	      imagestring($im, 12, 
	     $_X["2"]-10,//x du texte
	     $min_img+5,//y du texte
	      substr($class["x"]["max"], 0, 5),
	       $text_color);
	       
	  	}
	//$i++;
	//$nb_class--;
	}
	
	if($this->debug)
	{
	$this->print_stat();
	}
	   */  
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
