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

class Table_columnS //la classe pour les tableauxx tri�...
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

//             if(isset ($_GET["order_field"]) && $_GET["order_field"] !=  $key)//always start with ASC SORTING...
//             {
//                 $order_by = "ASC";
//             }
            if (isset ($_GET["order_by"]) && $_GET["order_by"] == "ASC")
            {
                $order_by = "DESC" ;//toggle ASC : DESC
            }
            else
            {
                $order_by = "ASC" ;
            }
//             else
//             {
//                 $order_by = "ASC" ;
//             }

            $url .= $order_by;

            if(isset($value["cannot_order"]))//tentative d'enlever les colonne non-triables...
            {
                $my_col = $value["col_title"];
            }
            else
            {
                $my_col = retournerHref($url, $value["col_title"]);//le lien hehe
            }

            if(isset ($_GET["order_field"]) && $key == $_GET["order_field"]
            && ($_GET["order_by"] == "ASC" || $_GET["order_by"] == "DESC"))//ajoute le DESC ou le ASC
            {
                $my_col .= " <span style=\"color: #00AA00;\">".$_GET["order_by"]."</span>";//ajoute le DESC ou le ASC
            }

            $first_row []= $my_col;
        }

        //statistics data...
        $donnees = array();//donn�s statistiques
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

            foreach($this->cols as $key => $value)//pour chaque colonne
            {
                if(!isset($value["no_statistics"]) && is_numeric($f[$key])
                //on enl�e les dates.//on enl�e les dates.
                && $f[$key]/1000000 < 1 &&//�imine les date
                !preg_match("/(name)|(title)|(id)|(online)|(nom)/i", $key))//numerique seulmement...//�imine les
                {
                    $donnees[$key] []= $f[$key];//on ajoute les donn�s num�iques
                }
            }
        }

        //order by hehe
        //les colonne existe-elle...
        if(isset ($_GET["order_field"]) && isset($this->cols[$_GET["order_field"]])
        && ($_GET["order_by"] == "ASC" OR $_GET["order_by"] == "DESC"))
        {
            $this->sql_base .=  " ORDER BY ".$_GET["order_field"]." ".$_GET["order_by"];
        }

    //LIMIT CLAUSE
        if(
        !(isset($_GET["start_page"]) && $_GET["start_page"] != "" && (int) $_GET["start_page"]
        && isset($_GET["per_page"]) && $_GET["per_page"] != "" && (int) $_GET["per_page"]))
        {
            $_GET["start_page"] = 1;

            $_GET["per_page"]  = $this->per_page;
        }

        $start_index = ($_GET["start_page"]-1)*$_GET["per_page"];

        $this->sql_base .=  " LIMIT $start_index, ".$_GET["per_page"]." ";

        $tableX = array();
        $tableX []= $first_row;

        $rs = $inicrond_db->Execute($this->sql_base);

        while ($f = $rs->FetchRow())
        {
            $ligne = array();

            foreach ($this->cols AS $key => $value)//pour chaque colonne
            {
                if(eval($value["col_data"]))
                {
                        //echo $value["col_data"];
                }

                $ligne []= $unit;//ajoute la cellule...
            }

            $tableX []= $ligne;//ajouter la ligne...
        }

    $data = array();//donn�s statistiques trait�s...

        //print_r($donnees);
        foreach($donnees AS $key => $value)
        {
            //print_r($value);

            $data[$key] = array();

            $data[$key] ['stat_n']= count($value);//n

            if(isset($this->cols[$key]["stat_col"]))
            {
                $the_key_for_Stat = "stat_col";
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

        //
        //Formatage des tableaux statistiques...

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

        if (isset ($_GET["order_field"]))
        {
            $this->base_url .= "&order_field=".$_GET["order_field"]."&order_by=".$_GET["order_by"];
        }

        while($i < ($max_page_number+1) && $i < 100)
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

        if(isset($tableX[1]))//donn�s comme telle.
        //retourne si il n'est pas vide
        {
            $return .= "<h2>".$_LANG['data']."</h2>";
            $return .= retournerTableauXY($tableX);//retourne le tableau...
        }

        if ($the_countage == 0)//there is no row!!!
        {
            return '';//return an empty string
        }
        else
        {
            return $return;
        }
    }
}

?>
