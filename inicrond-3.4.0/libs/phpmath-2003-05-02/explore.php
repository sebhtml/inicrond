<html>
<head>
  <title>Simple Linear Regression</title>
</head>
<body bgcolor="white">

<center>

<?php

include "navbar.php";

if (!empty($x_values)) {
  $X    = explode(",", $x_values);
  $numX = count($X);
}  

if (!empty($y_values)) {
  $Y    = explode(",", $y_values);
  $numY = count($Y);
}  

// redisplay entry form if data not entered correctly

if ( (empty($title)) OR (empty($x_name)) OR (empty($x_values)) OR (empty($y_name)) OR (empty($conf_int)) OR (empty($y_values)) OR ($numX != $numY) ) {
    
  ?> 

  <h2>Simple Linear Regression</h2>
  
  
  <table border='0' cellspacing='5' cellpadding='0'>
    <form method='post' action='<?php echo $PHP_SELF ?>'>
    <tr>
  	  <td>
        1. Title of Study
  	  </td>
  	</tr>
  	<tr>
  	  <td>
  	    <input type='text' name='title' size='30' value='<?php echo $title ?>'>
  	  </td>
  	</tr>
    <tr>
  	  <td>
        2. Enter X name
  	  </td>
  	</tr>
  	<tr>
  	  <td>
  	    <input type='text' name='x_name' size='30' value='<?php echo $x_name ?>'>
  	  </td>
  	</tr>
    <tr>
  	  <td>
        3. Enter comma separated X values
  	  </td>
  	</tr>
  	<tr>
  	  <td>
  	    <textarea name='x_values' rows='3' cols='50'><?php echo $x_values ?></textarea>
  	  </td>
  	</tr>
    <tr>
  	  <td>
        4. Enter Y name
  	  </td>
  	</tr>
  	<tr>
  	  <td>
  	    <input type='text' name='y_name' size='30' value='<?php echo $y_name ?>'>
  	  </td>
  	</tr>
    <tr>
  	  <td>
        5. Enter comma separated Y values
  	  </td>
  	</tr>
  	<tr>
  	  <td>
  	    <textarea name='y_values' rows='3' cols='50'><?php echo $y_values ?></textarea>
  	  </td>
  	</tr>
    <tr>
  	  <td>
        6. Confidence Interval
  	  </td>
  	</tr>
  	<tr>
  	  <td>
  	    <input type='text' name='conf_int' size='3' value='<?php echo $conf_int ?>'>%
  	  </td>
  	</tr>
    <tr>
  	  <td align='center'>
  	    <input type='submit' value='Analyse Data'>
  	  </td>
    </tr>
    </form>
  </table>

  <?php
} else {
  
  include_once "slr/SimpleLinearRegressionHTML.php";    
                  
  $slr = new SimpleLinearRegressionHTML($X, $Y, $conf_int); 
  
  echo "<h2>$title</h2>";
  
  $slr->showTableSummary($x_name, $y_name);
  echo "<br><br>";
  
  $slr->showAnalysisOfVariance();  
  echo "<br><br>";

  $slr->showParameterEstimates($x_name, $y_name); 
  echo "<br>";

  $slr->showFormula($x_name, $y_name);
  echo "<br><br>";

  $slr->showRValues($x_name, $y_name);
  echo "<br>";

  include ("jpgraph/jpgraph.php");
  include ("jpgraph/jpgraph_scatter.php");
  include ("jpgraph/jpgraph_line.php");
  
  // The first graph to display is a scatter plus line plot  
  $graph = new Graph(300,200,'auto');
  $graph->SetScale("linlin");
  
  // Setup title  
  $graph->title->Set("$title");
  $graph->img->SetMargin(50,20,20,40);   
  $graph->xaxis->SetTitle("$x_name","center");
  $graph->yaxis->SetTitleMargin(30);     
  $graph->yaxis->title->Set("$y_name"); 
  
  $graph->title->SetFont(FF_FONT1,FS_BOLD);
  
  // make sure that the X-axis is always at the
  // bottom at the plot and not just at Y=0 which is
  // the default position  
  $graph->xaxis->SetPos('min');
  
  // Create the scatter plot with some nice colors
  $sp1 = new ScatterPlot($slr->Y, $slr->X);
  $sp1->mark->SetType(MARK_FILLEDCIRCLE);
  $sp1->mark->SetFillColor("red");
  $sp1->SetColor("blue");
  $sp1->SetWeight(3);
  $sp1->mark->SetWidth(4);
  
  // Create the regression line
  $lplot = new LinePlot($slr->PredictedY, $slr->X);
  $lplot->SetWeight(2);
  $lplot->SetColor('navy');
  
  // Add the pltos to the line
  $graph->Add($sp1);
  $graph->Add($lplot);
  
  // ... and stroke
  $graph_name = "temp/test.png";
  $graph->Stroke($graph_name);
  ?>
  <img src='<?php echo $graph_name ?>' vspace='15'>
  <br><br>  
  <?php 
  // Second graph displays residuals as function of predicted Y values
  $graph2 = new Graph(300,200,'auto');
  $graph2->SetScale("linlin");
  
  // Setup title  
  $graph2->title->Set("$title");
  $graph2->img->SetMargin(60,20,20,40); 
  $graph2->xaxis->SetTitle("Predicted Y","center");
  $graph2->yaxis->SetTitleMargin(40);   
  $graph2->yaxis->title->Set("Residual"); 
 
  $graph2->title->SetFont(FF_FONT1,FS_BOLD);  
  $graph2->xaxis->SetPos('min');
  
  $sp2 = new ScatterPlot($slr->Error, $slr->PredictedY);
  $sp2->mark->SetType(MARK_FILLEDCIRCLE);
  $sp2->mark->SetFillColor("red");
  $sp2->SetColor("blue");
  $sp2->SetWeight(3);
  $sp2->mark->SetWidth(4);
  
  $graph2->Add($sp2);
  
  $graph_name = "temp/test2.png";
  $graph2->Stroke($graph_name);

  ?>
  <img src='<?php echo $graph_name ?>' vspace='15'>  
  <form>
    <input type='Button' value='Back' onClick='history.go(-1)'>
  </form>
  <?php
}
?>
</center>
</body>
</html>