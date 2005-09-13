<?php
//$Id$



/*
//---------------------------------------------------------------------
//

//Auteur : sebastien boisvert
//email : sebhtml@users.sourceforge.net
//site web : http://inicrond.sourceforge.net/
//Projet : inicrond
//
//---------------------------------------------------------------------
*/
/*


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


*/

if(__INICROND_INCLUDED__)
{
        
        
        class Table_columnS //la classe pour les tableauxx triés...
        {
                var $sql_base;//la requete de base
                var $cols;//les colonnes
                var $base_url;//l'url de base pour le fichier php.
                var $_LANG;//le language...
                var $per_page ;
                var $inicrond_db;
                
                
                
                /**
                * an html output function
                *
                * @author       Sebastien Boisvert sebhtml@users.sourceforge.net
                * @version      1.0.0
                */		
                function OUTPUT()
                {
                        $_LANG = $this->_LANG;
                        $inicrond_db = $this->inicrond_db;
                        
                        if(isset($_GET["start_page"]))
                        {
                                
                                $this->base_url .= "&start_page=".$_GET["start_page"];
                                
                        }
                        $this->base_url .= "&per_page=".$this->per_page."";
                        
                        
                        
                        
                        
                        
                        
                        
			
                        $first_row = array();//les colonnes...
                        
                        foreach($this->cols AS $key => $value)//pour chaque colones
                        {
                                $url = $this->base_url."&order_field=$key&order_by=";
                                
                                if($_GET["order_field"] !=  $key)//always start with ASC SORTING...
                                {
                                        $order_by = "ASC";
                                }
                                else
                                {
                                        $order_by =  ($_GET["order_by"] == "ASC") ? "DESC" : "ASC";//toggle ASC : DESC
                                }
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
                        //statistics data...
                        $donnees = array();//données statistiques
                        /*
                        echo $this->sql_base;
                        exit;*/
                        
                        $rs = $inicrond_db->Execute($this->sql_base);
                        //die($this->sql_base);
                        //print_r($r);
                        $the_countage = 0;
                        
                        while($f = $rs->FetchRow())
                        {
                                $the_countage++;
                                
                                $ligne = array();
                                
                                foreach($this->cols AS $key => $value)//pour chaque colonne
                                {
                                        
                                        if(
                                        !isset($value["no_statistics"]) AND
                                        (
                                        is_numeric($f[$key])
                                        ) AND
                                        //on enlève les dates.//on enlève les dates.
                                        $f[$key]/1000000 < 1 AND//élimine les date
                                        !preg_match("/(name)|(title)|(id)|(online)|(nom)/i", $key)//élimine les
                                        
                                        
                                        )//numerique seulmement...
                                        {
                                                $donnees[$key] []= $f[$key];//on ajoute les données numériques
                                        }
                                        
                                        
                                        
                                        
                                        
                                        //	print_r($value);
                                        
                                        
                                        
                                        
                                }
                                
                                
                                //end of statisztic aquisition.
                                
                        }
                        
                        //order by hehe
                        if(isset($this->cols[$_GET["order_field"]]) AND//les colonne existe-elle...
                        ($_GET["order_by"] == "ASC" OR $_GET["order_by"] == "DESC")
                        )
                        {
                                
				
                                $this->sql_base .=  " ORDER BY ".$_GET["order_field"]." ".$_GET["order_by"];
				
                                
                                
                                
                        }
                        //LIMIT CLAUSE
                        if(
                        !(isset($_GET["start_page"]) AND
                        $_GET["start_page"] != "" AND
                        (int) $_GET["start_page"] AND
                        
                        isset($_GET["per_page"]) AND
                        $_GET["per_page"] != "" AND
                        (int) $_GET["per_page"] 
                        )
                        )
                        {
                                $_GET["start_page"] = 1;
                                
                                $_GET["per_page"]  = $this->per_page;
                                
                        }
                        $start_index = ($_GET["start_page"]-1)*$_GET["per_page"];
                        
                        $this->sql_base .=  " LIMIT $start_index, ".$_GET["per_page"]." ";
                        
                        
                        $tableX = array();
                        $tableX []= $first_row;
                        
			
                        
                        
                        $rs = $inicrond_db->Execute($this->sql_base);
                        
                        
                        while($f = $rs->FetchRow())
                        {
                                //print_r($f);
                                
                                $ligne = array();
                                
                                //print_r($this->cols);
                                foreach($this->cols AS $key => $value)//pour chaque colonne
                                {
                                        
                                        
                                        
                                        
                                        
                                        if(eval($value["col_data"]))
                                        {
                                                //echo $value["col_data"];
                                        }
                                        
                                        
                                        
                                        $ligne []= $unit;//ajoute la cellule...
                                }
                                $tableX []= $ligne;//ajouter la ligne...		
                        }
                        
                        
                        
                        $data = array();//données statistiques traitées...
                        //
                        //print_r($donnees);
                        foreach($donnees AS $key => $value)
                        {
                                
                                //print_r($value);
                                
                                $data[$key] = array();
                                
                                
                                
                                $data[$key] ['stat_n']= count($value);//n
                                
                                if(isset($this->cols[$key]["stat_col"]))
                                {
                                        $the_key_for_Stat = "stat_col";
                                        //die($this->cols[$key]["stat_col"]);//debug
                                }
                                else
                                {
                                        $the_key_for_Stat = "col_data";
                                        
                                }
                                
                                //$the_key_for_Stat = "stat_col";//debug
                                
                                $f[$key] = moyenne($value);
                                eval($this->cols[$key][$the_key_for_Stat]);//moyenne
                                
                                $data[$key] ['stat_x-barre']= $unit ;
                                
                                $f[$key] = ecart_type_corrige($value);
                                eval($this->cols[$key][$the_key_for_Stat]);//ecart type
                                
                                $data[$key] ['stat_s']= $unit;
                                
                                $f[$key] = somme_x($value);
                                eval($this->cols[$key][$the_key_for_Stat]);//some X
                                
                                $data[$key] ['stat_sum']= $unit;
                                
                                //print_r($data[$key]);
                                //exit();
                                
                        }
                        
                        $TABL = array(
                        "col_title" => array(""),
                        //'stat_n' => array($_LANG['stat_n']),
                        'stat_x-barre' => array($_LANG['stat_x-barre']),
                        'stat_s' => array($_LANG['stat_s']),
                        'stat_sum' => array($_LANG['stat_sum'])
                        );
                        
                        //$the_countage = count($value);//the countage
                        //
                        //Formatage des tableaux statistiques...
                        //
                        //print_r($TABL);
                        //exit();
                        
                        foreach($data AS $key => $value)//add the columns
                        {
                                $TABL["col_title"] []= $this->cols[$key]["col_title"];
                                //$TABL['stat_n'] []= $the_countage;
                                
                                $TABL['stat_x-barre'] []= $value['stat_x-barre'];
                                $TABL['stat_s'] []= $value['stat_s'];
                                $TABL['stat_sum'] []= $value['stat_sum'];
                                
                        }
                        
                        //the page links...
                        $max_page_number = $the_countage/$_GET["per_page"];
                        $table_page_links = array();
                        $i = 1;
                        $this->base_url .= "&order_field=".$_GET["order_field"]."&order_by=".$_GET["order_by"];
                        while($i < ($max_page_number+1)  AND
                        $i < 100
                        )
                        {
                                $txt = $i == $_GET["start_page"] ? "<b>".$i."</b>" : $i ;
                                
                                $table_page_links []= retournerHref(
                                $this->base_url."&start_page=".$i,//the link
                                $txt//the txt
                                );
                                
                                $i++;
                        }
                        //end of page links
                        $table_page_links = array($table_page_links);
                        $return = "";
                        $return .= "<h2>".$_LANG['stats']."</h2>";
                        $return .= "<i>n = $the_countage </i>";
                        
                        if(isset($TABL["col_title"][1]))//at least one column
                        {
                                $return  .= retournerTableauXY($TABL);
                        }
                        
                        if(isset($table_page_links[0][1]))//pages
                        //at last page #2
                        {
                                $return .= "<h2>".$_LANG['pages']."</h2>";
                                $return  .= retournerTableauXY($table_page_links);
                        }
                        if(isset($tableX[1]))//données comme telle.
                        //retourne si il n'est pas vide
                        {
                                $return .= "<h2>".$_LANG['data']."</h2>";
                                $return .= retournerTableauXY($tableX);//retourne le tableau...
                        }
                        
                        
                        {
                                
                                /*
                                $return .=
                                nl2br($this->sql_base);
                                */
                                
                        }
                        if($the_countage === 0)//there is no row!!!
                        {
                        return '';//return an empty string
                        }
                        else
                        {
                        return $return;
                        }
                        
                }
        }
        
}

?>
