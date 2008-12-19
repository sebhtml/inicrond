<?php    
/**
 * Usage example for Image_Graph.
 * 
 * Main purpose: 
 * Demonstrate SWF driver
 * 
 * Other: 
 * None specific
 * 
 * $Id: driver_swf03.php 8 2005-09-13 17:44:21Z sebhtml $
 * 
 * @package Image_Graph
 * @author Jesper Veggerby <pear.nosey@veggerby.dk>
 */

require 'Image/Graph.php';
require 'Image/Graph/Driver.php';

$Driver =& Image_Graph_Driver::factory('swf', array('width' => 600, 'height' => 400));


// create the graph
$Graph =& Image_Graph::factory('graph', &$Driver); 
// add a TrueType font
$Font =& $Graph->addNew('ttf_font', 'Gothic');
// set the font size to 11 pixels
$Font->setSize(11);

$Graph->add(
    Image_Graph::vertical(
        Image_Graph::factory('title', array('Simple Line Chart Sample', &$Font)),        
        Image_Graph::vertical(
            $Plotarea = Image_Graph::factory('plotarea'),
            $Legend = Image_Graph::factory('legend'),
            90
        ),
        5
    )
);   
$Legend->setPlotarea($Plotarea);

// create the dataset
$Dataset =& Image_Graph::factory('random', array(10, 2, 15, true));
// create the 1st plot as smoothed area chart using the 1st dataset
$Plot =& $Plotarea->addNew('line', &$Dataset);

// set a line color
$Plot->setLineColor('red');   
        
// output the Graph
$Graph->done();
?>