<?php
/*
    $Id: Correlation_plot.php 83 2005-12-26 20:28:15Z sebhtml $

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

include PEAR_PATH."Image/Graph.php";
include PEAR_PATH."Image/Graph/Dataset/Trivial.php";
include PEAR_PATH."Image/Graph/Plot/Dot.php";
include PEAR_PATH."Image/Graph/Marker/Triangle.php";
include PEAR_PATH."Image/Graph/Font/TTF.php";

include PEAR_PATH."Image/Graph/Title.php";
include PEAR_PATH."Image/Graph/Plotarea.php";
include PEAR_PATH."Image/Graph/DataPreprocessor/Function.php";
include PEAR_PATH."Math/Stats.php";
include __INICROND_INCLUDE_PATH__."libs/phpmath-2003-05-02/SimpleLinearRegression.php";

function Y_func($value)
{
        return $value."%";
}

class Correlation_plot//class of result set.
{//start of class.

        var $inicrond_db;
        var $title;
        var $query;
        var $x_preprocessor;
        var $y_preprocessor;

        function render()
        {
                $data = array ();
                $X = array();
                $Y = array();
                $r = $this->inicrond_db->Execute($this->query);
                //$i = 0 ;
                //$x_data = array();//this array will hold the X values.

                while($f = $r->FetchRow())
                {
                        //$i++;
                        $data []= array( 'x' => $f['x_val'], 'y' => $f['y_val']);//by day.

                        //$x_data []= $key;//add the X point.
                        $X []= $f['x_val'];
                        $Y []= $f['y_val'];
                }


                $Dataset = new Image_Graph_Dataset_Trivial;

                foreach($data AS $value)
                {
                        $Dataset->addPoint($value['x'], $value['y']);
                }

                $Plot = new Image_Graph_Plot_Dot($Dataset );

                $marker = new Image_Graph_Marker_Triangle;

                $Plot->setMarker( $marker);
                $Graph = new Image_Graph(800, 600);                // create the graph

                // add a TrueType font
                $Arial =& $Graph->setFont(new Image_Graph_Font_TTF(PEAR_PATH."Image/Graph/Fonts/arial.ttf"));

                $Plotarea = new Image_Graph_Plotarea("axis", "axis");

                $AxisX =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
                $AxisX->setDataPreprocessor(new Image_Graph_DataPreprocessor_Function($this->x_preprocessor));

                $AxisY =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);
                $AxisY->setDataPreprocessor(new Image_Graph_DataPreprocessor_Function($this->y_preprocessor));

                $Plotarea->add($Plot);
                $Plotarea->_padding = 15;
                //add the regression line...
                // instantiating a Math_Stats object

                /////////////////////////////////////////////////////
                //trace the correlation line :.
                $SimpleLinearRegression= new SimpleLinearRegression($X, $Y, $ConfidenceInterval);

                $correlation_line_points = array(
                //the first predicted point
                min($X) => min($X)*$SimpleLinearRegression->Slope+$SimpleLinearRegression->YInt,
                //the last predicted point.
                max($X) => max($X)*$SimpleLinearRegression->Slope+$SimpleLinearRegression->YInt
                );

                //create the dataset.
                $Dataset2 = new Image_Graph_Dataset_Trivial;

                foreach($correlation_line_points AS $key => $value)
                {
                        $Dataset2->addPoint($key, $value);
                }

                $Plot2 =& $Plotarea->addNew('line', &$Dataset2);

                // set a line color
                $Plot2->setLineColor('red');

                //////////////////////
                //put the clope, the Yint r and r2 and count. on the graphic. in the title.

                $Graph->add(new Image_Graph_Title($this->title." [ ".
                "y = ".sprintf(__SPRINTF_SIGNIFICANTS_DIGITS_FORMAT__,$SimpleLinearRegression->Slope)." * x + ".sprintf(__SPRINTF_SIGNIFICANTS_DIGITS_FORMAT__,$SimpleLinearRegression->YInt).", r = ".sprintf(__SPRINTF_SIGNIFICANTS_DIGITS_FORMAT__, $SimpleLinearRegression->R).", r^2 = ".sprintf(__SPRINTF_SIGNIFICANTS_DIGITS_FORMAT__,$SimpleLinearRegression->RSquared).", n = ".$SimpleLinearRegression->n."  ]",
                $Arial));

                $Graph->add($Plotarea);

                $Graph->_showTime = TRUE;

                $Graph->_hideLogo = TRUE ;
                //$Graph->_showTime = TRUE;

                //ob_clean();
                $Graph->Done(IMG_PNG);
        }//end of render.
}//end of class

?>