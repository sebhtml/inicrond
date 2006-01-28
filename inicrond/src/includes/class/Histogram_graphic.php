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
/*
visits length
marks length
tests length
marks score
tests scores.
blue_master_clone stuff.

*/

include PEAR_PATH."Image/Graph.php";
include PEAR_PATH."Image/Graph/Dataset/Trivial.php";
include PEAR_PATH."Image/Graph/Plot/Bar.php";
include PEAR_PATH."Image/Graph/Font/TTF.php";
include PEAR_PATH."Image/Graph/Title.php";
include PEAR_PATH."Image/Graph/Plotarea.php";
include PEAR_PATH."Image/Graph/DataPreprocessor/Function.php";
include PEAR_PATH."Math/Histogram.php";

function X_func($value)
{
        return (int)$value."%";
}

class Histogram_graphic//class of result set.
{//start of class.
        var $inicrond_db;
        var $title;
        var $query;
        var $preprocessor;
        var $vals;

        function render()
        {
                if(!isset($this->vals))
                {
                        $vals = array();

                        $r = $this->inicrond_db->Execute($this->query);
                        $count=0;
                        while($f = $r->FetchRow())
                        {
                                $count++;
                                $vals []=  $f["value"];//by day.
                        }
                }
                else
                {
                        $vals = $this->vals;
                        $count=count($vals);
                }

                // create an instance
                $h = new Math_Histogram();

                // let's do a cummulative histogram
                $h->setType(HISTOGRAM_CUMULATIVE, 10, min($vals), max($vals));
                $h->setData($vals);
                $h->calculate();
                $t = $h->getHistogramInfo();

                $Dataset = new Image_Graph_Dataset_Trivial();

                $xs = array();

                foreach($t["bins"] AS $key => $value)
                {
                        $Dataset->addPoint($value["mid"], $value['count']);

                        $xs []= $value["mid"];
                }

                $Plot = new Image_Graph_Plot_Bar($Dataset );

                $Graph = new Image_Graph(800, 600);                // create the graph
                // set a line color

                // add a TrueType font
                $Arial =& $Graph->setFont(new Image_Graph_Font_TTF(PEAR_PATH."Image/Graph/Fonts/arial.ttf"));
                // set the font size to 15 pixels
                // $Arial->setSize(11);
                // add a title using the created font
                $Graph->add(new Image_Graph_Title($this->title." [ n = $count ]", $Arial));

                $Plotarea = new Image_Graph_Plotarea();

                $Plotarea->add($Plot);
                $Plotarea->_padding = 15;
                $AxisX =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
                $AxisX->setDataPreprocessor(new Image_Graph_DataPreprocessor_Function($this->preprocessor));

                $Graph->add($Plotarea);

                $Graph->_hideLogo = TRUE ;
                //$Graph->_showTime = TRUE;
                $Graph->_showTime = TRUE;
                //ob_clean();
                //header("Content-Type: application/force-download");
                $Graph->Done(IMG_PNG);
        }//end of render.
}//end of class

?>