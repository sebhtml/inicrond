<?php
//$Id$


/*
//---------------------------------------------------------------------
//
//
//Fonction du fichier : classe de connexion database
//
//
//Auteur : sebastien boisvert
//email : sebhtml@yahoo.ca
//site web : http://membres.lycos.fr/zs8
//Projet : kovistaz
//
//---------------------------------------------------------------------
*/
/*


__LICENSE_GPL__


*/

if(isset($_OPTIONS["INCLUDED"]))
{


class Table_columnS //la classe pour les tableauxx triés...
{
var $sql_base;//la requete de base
var $mon_objet;//l'objet pour la connexion
var $cols;//les colonnes
var $base_url;//l'url de base pour le fichier php.
var $_LANG;//le language...

	function __construct()//constructeur...
	
	{
	
	}
	
	function SET_sql_base($sql_base)//setter
	{
	$this->sql_base = $sql_base;
	}
	function SET__LANG($_LANG)//setter
	{
	$this->_LANG = $_LANG;
	}
	function SET_mon_objet($mon_objet)//setter
	{
	$this->mon_objet = $mon_objet;
	}
	
	function SET_base_url($base_url)//setter
	{
	$this->base_url = $base_url;
	}
	
	function SET_cols($cols)//setter
	{
	$this->cols = $cols;
	}
	
	function OUTPUT()
	{
	$_LANG = $this->_LANG;
	
	//echo "sa";
	
	//order by hehe
		if(isset($this->cols[$_GET["order_field"]]) AND//les colonne existe-elle...
		($_GET["order_by"] == "ASC" OR $_GET["order_by"] == "DESC")
		)
		{
			
				
		$this->sql_base .=  " ORDER BY ".$_GET["order_field"]." ".$_GET["order_by"];
				
			
		
		
		}
		
	$first_row = array();//les colonnes...
		
		foreach($this->cols AS $key => $value)//pour chaque colones
		{
		$url = $this->base_url."&order_field=$key&order_by=";
			
		
			$order_by =  ($_GET["order_by"] == "ASC") ? "DESC" : "ASC";//toggle ASC : DESC
			
			$url .= $order_by;
			
			
			if(isset($value["cannot_order"]))//tentative d'enlever les colonne non-triables...
			{
			$my_col = $value["col_title"];
						
			}
			else
			{
$my_col = retournerHref($url, $value["col_title"]);//le lien hehe
			}
			
			
		/*
		echo $key;
		echo $_GET["order_field"];
		exit();
		*/
			if($key == $_GET["order_field"] AND
			($_GET["order_by"] == "ASC" OR $_GET["order_by"] == "DESC")
			)//ajoute le DESC ou le ASC
			{
			//die("33");
			
			$my_col .= " <span style=\"color: #00AA00;\">".$_GET["order_by"]."</span>";//ajoute le DESC ou le ASC
			}
		
		$first_row []= $my_col;
		}

	$tableX = array();
		$tableX []= $first_row;

	
	$r = $this->mon_objet->query($this->sql_base);
	
	//die(nl2br($this->sql_base));
	
	$donnees = array();//données statistiques
	
		while($f = $this->mon_objet->fetch_assoc($r))
		{
		//print_r($f);
		
		$ligne = array();
		
		//print_r($this->cols);
			foreach($this->cols AS $key => $value)//pour chaque colonne
			{
			
			if(is_numeric($f[$key]) AND
			$f[$key]/1000000 < 1//on enlève les dates.
			)//numerique seulmement...
			{
			$donnees[$key] []= $f[$key];//on ajoute les données numériques
			}
			
		//	print_r($value);
			
			

			
			//die($php_exec);
			//echo $php_exec."<br />";	
			
			
					
			eval($value["col_data"]);
			
		//	echo $value["col_data"]."<br />";
			
			$ligne []= $unit;//ajoute la cellule...
			}
		$tableX []= $ligne;//ajouter la ligne...		
		}
		
	$this->mon_objet->free_result($r);
	
	$data = array();//données statistiques traitées...
//
	//print_r($donnees);
	foreach($donnees AS $key => $value)
	{
	
	//print_r($value);
	
	$data[$key] = array();
	
	
	$data[$key] []= count($value);//n
	
	$f[$key] = moyenne($value);
	eval($this->cols[$key]["col_data"]);//moyenne
	
	$data[$key] []= $unit ;
	
	$f[$key] = ecart_type_corrige($value);
	eval($this->cols[$key]["col_data"]);//ecart type
	
	$data[$key] []= $unit;
	
	$f[$key] = somme_x($value);
	eval($this->cols[$key]["col_data"]);//some X
	
	$data[$key] []= $unit;
	
	//print_r($data[$key]);
	//exit();
	
	}
	
	$TABL = array(
	"0" => array(""),
	"1" => array($_LANG["stat"]["n"]),
	"2" => array($_LANG["stat"]["x-barre"]),
	"3" => array($_LANG["stat"]["s"]),
	"4" => array($_LANG["stat"]["sum"])

	)
;
	
	foreach($data AS $key => $value)
	{
$TABL[0] []= $this->cols[$key]["col_title"];
$TABL[1] []= $value[0];
$TABL[2] []= $value[1];
$TABL[3] []= $value[2];
$TABL[4] []= $value[3];
	}
	//
	//Formatage des tableaux statistiques...
	//
	//print_r($TABL);
	//exit();
	
	
	$return = "";
	
	if(isset($TABL[0][1]))//des données ???
	{
	$return  .= retournerTableauXY($TABL);
	}
	if(isset($tableX[1]))//retourne si il n'est pas vide
	{
	$return .= retournerTableauXY($tableX);//retourne le tableau...
	}

	
	return $return;
	
	}
}
}

?>
