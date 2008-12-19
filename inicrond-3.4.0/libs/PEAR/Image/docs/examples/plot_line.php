<?php
/**
 * Usage example for Image_Graph.
 * 
 * Main purpose: 
 * Show line chart
 * 
 * Other: 
 * None specific
 * 
 * $Id: plot_line.php 8 2005-09-13 17:44:21Z sebhtml $
 * 
 * @package Image_Graph
 * @author Jesper Veggerby <pear.nosey@veggerby.dk>
 */

require 'Image/Graph.php';

// create the graph
$Graph =& Image_Graph::factory('graph', array(400, 300));

// add a TrueType font
$Font =& $Graph->addNew('ttf_font', 'Gothic');
// set the font size to 11 pixels
$Font->setSize(10);

$Graph->setFont($Font);

// setup the plotarea, legend and their layout
$Graph->add(
   Image_Graph::vertical(
      Image_Graph::factory('title', array('Simple Line Chart Sample', 12)),        
      Image_Graph::vertical(
         $Plotarea = Image_Graph::factory('plotarea'),
         $Legend = Image_Graph::factory('legend'),
         88
      ),
      5
   )
);   

// link the legend with the plotares
$Legend->setPlotarea($Plotarea);

// create a random dataset for sake of simplicity
$Dataset =& Image_Graph::factory('random', array(10, 2, 15, true));
// create the plot as line chart using the dataset
$Plot =& $Plotarea->addNew('line', &$Dataset);

// set a line color
$Plot->setLineColor('red');                  
     
// output the Graph
$Graph->done();
?>