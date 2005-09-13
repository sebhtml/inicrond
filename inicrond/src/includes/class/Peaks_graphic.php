<?php
/*---------------------------------------------------------------------

$Id$

sebastien boisvert <sebhtml at yahoo dot ca> <http://inicrond.sourceforge.net/>

inicrond Copyright (C) 2004-2005  Sebastien Boisvert

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
-----------------------------------------------------------------------*/
/*
visits
swf attempts
test atempts
forum post
forum view
download.



*/

function format_date($value)
{
        return date("Y-m-d", ($value*24*60*60));
        
}
include PEAR_PATH."Math/Stats.php";
include PEAR_PATH."Image/Graph.php";
include PEAR_PATH."Image/Graph/Dataset/Trivial.php";
include PEAR_PATH."Image/Graph/Plot/Line.php";
include PEAR_PATH."Image/Graph/Marker/Cross.php";
include PEAR_PATH."Image/Graph/Font/TTF.php";
include PEAR_PATH."Image/Graph/Title.php";
include PEAR_PATH."Image/Graph/Plotarea.php";
include PEAR_PATH."Image/Graph/DataPreprocessor/Function.php";


class Peaks_graphic//class of result set.
{//start of class.
        
        var $inicrond_db;
        var $title;
        var $query;
        
        function render()
        {
                $data = array ();
                $r = $this->inicrond_db->Execute($this->query);
                $count = 0;
                while($f = $r->FetchRow())
                {
                        $count++;
                        $data []=  round(inicrond_convert_time_t_to_user_tz($f["time_t"])/(60*60*24));//by day.
                }
                
                
                
                // instantiating a Math_Stats object
                $s = new Math_Stats();
                
                $s->setData($data);
                
                //print_r($s->calcBasic());
                
                $t = $s->calcFull();
                
                //print_r($t["frequency"]); exit();
                
                
                
                
                
                
                
                
                
                
                $X_values = array_keys($t["frequency"]);
                
                $min_x = min($X_values);
                $max_x = max($X_values);
                
                //echo $min_x." max<br />";
                //echo $max_x." min<br />";
                
                for($i = $min_x ; $i < $max_x ; $i += 1)
                {
                        //echo $i."<br />";
                        
                        if(!isset($t["frequency"][$i]))
                        {
                                $t["frequency"][$i] = 0 ;
                        }
                }
                
                //exit();
                ksort($t["frequency"]);
                
                
                
                
                $Dataset =& new Image_Graph_Dataset_Trivial();
                foreach($t["frequency"] AS $key => $value)
                {
                        $Dataset->addPoint($key, $value);         
                        
                }
                
                
                $Plot = new Image_Graph_Plot_Line($Dataset );
                
                /*$Fillstyle = new Image_Graph_Fill_Gradient ( (IMAGE_GRAPH_GRAD_VERTICAL),  0xAAEEFF, 0xFFDDEE);
                // create the fill style as a solid fill with the newly created color
                
                $Plot->setFillStyle($Fillstyle);*/
                
                $Graph =& new Image_Graph(800, 600);                // create the graph
                //styles.
                // add a TrueType font
                $Arial =& $Graph->setFont(new Image_Graph_Font_TTF(PEAR_PATH."Image/Graph/Fonts/arial.ttf"));
                // set the font size to 15 pixels
                //$Arial->setSize(11);
                // add a title using the created font
                $Graph->add(new Image_Graph_Title($this->title." [ n = $count ]", $Arial, 10));
                
                
                
                
                
                $Plotarea = new Image_Graph_Plotarea("axis", "axis");
                
                
                $AxisX =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
                $AxisX->setDataPreprocessor(new Image_Graph_DataPreprocessor_Function("format_date"));
                
                /////////////
                //set the data interval..
                //in days.
                //show 4 label.
                //    $x_data = array_keys($t["frequency"]);
                // $AxisX->setLabelInterval((max($x_data) - min($x_data))/4);
                /*  
                //add x value
                include PEAR_PATH."Image/Graph/Marker/Value.php";
                
                function value_marker($input)
                {
                        global $t;
                        
                        if($t["frequency"][$input] > 2)//2 visits
                        {
                                return format_date($input);
                        }
                        else
                        {
                                return NULL;
                        }
                }
                
                include PEAR_PATH."Image/Graph/Marker/Pointing/Angular.php";
                
                ////////////
                $Marker =& new Image_Graph_Marker_Value(IMAGE_GRAPH_VALUE_X);
                // fill it with white
                //  $Marker->setFillColor(IMAGE_GRAPH_WHITE);
                // and use black border
                //   $Marker->setBorderColor(IMAGE_GRAPH_BLACK);
                // create a pin-point marker type
                $PointingMarker =& $Plot->add(new Image_Graph_Marker_Pointing_Angular(20, $Marker));
                // and use the marker on the 1st plot
                $Plot->setMarker($PointingMarker);    
                // format value marker labels as percentage values
                //  $Marker->setDataPreProcessor(new Image_Graph_DataPreprocessor_Formatted("%0.1f%%"));
                
                /////////////////////
                
                
                //$Plot->setMarker($Marker); 
                $Marker->setDataPreprocessor(new Image_Graph_DataPreprocessor_Function("value_marker"));
                */
                $Plotarea->add($Plot);
                $Plotarea->_padding = 15;
                
                /*$Plot2 = new Image_Graph_Plot_Dot($Dataset );
                
                $marker = new Image_Graph_Marker_Diamond () ;
                
                $Plot2->setMarker( $marker);
                
                $Plotarea->addPlot($Plot2);*/
                
                $Graph->add($Plotarea);        // create the plotarea
                
                $Graph->_hideLogo = TRUE ;
                
                
                $Graph->_showTime = TRUE;
                
                
                ob_clean();
                header("Content-Type: application/force-download");
                $Graph->Done(IMG_PNG); 
                
        }//end of render.
}//end of class

?>