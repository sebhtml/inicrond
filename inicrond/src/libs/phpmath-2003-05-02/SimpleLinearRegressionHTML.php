<?php

// SimpleLinearRegressionHTML.php

// Copyright 2003, Paul Meagher
// Distributed under GPL  

include_once "slr/SimpleLinearRegression.php";

class SimpleLinearRegressionHTML extends SimpleLinearRegression {

  function SimpleLinearRegressionHTML($X, $Y, $conf_int) {
    SimpleLinearRegression::SimpleLinearRegression($X, $Y, $conf_int);
  }
   
  function showTableSummary($x_name, $y_name) {    
    $ConfInt = $this->ConfInt ."%";
    ?>    
    <table width='550' border='1' cellpadding='3' align='center'>
      <tr bgcolor='silver'>
        <th colspan='6'>Table Summary</th>
      </tr>
      <tr>
        <th align='center'><?php echo $x_name ?></th>
        <th align='center'><?php echo $y_name ?></th>
        <th align='center'>Predicted</th>
        <th align='center'>Residual</th>
        <th align='center'>Lower <?php echo $ConfInt ?></th>
        <th align='center'>Upper <?php echo $ConfInt ?></th>        
      </tr>
      <?php
      for ($i = 0; $i < $this->n; $i++) {
        $PredictedY   = sprintf($this->format, $this->PredictedY[$i]);
        $Error        = sprintf($this->format, $this->Error[$i]);
        $SquaredError = sprintf($this->format, $this->SquaredError[$i]);
        $Interval     = $this->AlphaTVal * $this->StdErr * sqrt(1 + 1/$this->n + pow(($this->X[$i] - $this->XMean), 2) / $this->SumXX);
        $LowerBound   = sprintf($this->format,$this->PredictedY[$i] - $Interval);          
        $UpperBound   = sprintf($this->format,$this->PredictedY[$i] + $Interval);
        echo "<tr>";
        echo "  <td align='center'>".$this->X[$i]."</td>";
        echo "  <td align='center'>".$this->Y[$i]."</td>";
        echo "  <td align='center'>$PredictedY</td>";
        echo "  <td align='center'>$Error</td>";
        echo "  <td align='center'>$LowerBound</td>";        
        echo "  <td align='center'>$UpperBound</td>";
        echo "</tr>";
      }
      ?>
    </table>
    <?php
  }
  
  function showAnalysisOfVariance() {                  
    $ModelError      = sprintf($this->format, $this->TotalError - $this->SumSquaredError);
    $FValue          = sprintf($this->format, ($this->TotalError - $this->SumSquaredError) / $this->ErrorVariance);    
    $SumSquaredError = sprintf($this->format, $this->SumSquaredError);            
    $ErrorVariance   = sprintf($this->format, $this->ErrorVariance);
    $TotalError      = sprintf($this->format, $this->TotalError);                
    ?>        
    <table border='1' cellpadding='3'>
      <tr bgcolor='silver'>
        <th colspan='5'>Analysis Of Variance</th>
      </tr>
      <tr>
        <th>Source</th><th>df</th><th>Sum Of Squares</th><th>Mean Square</th><th>F Value</th>
      </tr>
      <tr> 
         <td>Model</td> 
         <td align='right'><?php echo 1 ?></td>          
         <td align='right'><?php echo $ModelError ?></td> 
         <td align='right'><?php echo $ModelError ?></td>        
         <td align='right'><?php echo $FValue ?></td>               
      </tr>
      <tr> 
         <td>Error</td> 
         <td align='right'><?php echo ($this->n - 2) ?></td>                   
         <td align='right'><?php echo $SumSquaredError ?></td> 
         <td align='right'><?php echo $ErrorVariance ?></td>        
         <td align='right'>&nbsp;</td>                                     
      </tr>
      <tr> 
         <td>Total</td> 
         <td align='right'><?php echo ($this->n - 1) ?></td>                            
         <td align='right'><?php echo $TotalError ?></td> 
         <td align='right'>&nbsp;</td>        
         <td align='right'>&nbsp;</td>               
      </tr>
    </table>    
    <?php
  }

  function showParameterEstimates() {          
    // Values for Slope
    $Slope        = sprintf($this->format, $this->Slope);  
    $SlopeStdErr  = sprintf($this->format, $this->SlopeStdErr);                
    $SlopeTVal    = sprintf($this->format, $this->SlopeTVal);
    $SlopeProb    = sprintf("%01.5f", $this->SlopeProb);                                           
    // Values for Y Intercept
    $YInt         = sprintf($this->format, $this->YInt);
    $YIntStdErr   = sprintf($this->format, $this->YIntStdErr);                    
    $YIntTVal     = sprintf($this->format, $this->YIntTVal);                
    $YIntProb     = sprintf("%01.5f", $this->YIntProb);                           
    ?>    
    <table border='1' cellpadding='3'>
      <tr bgcolor='silver'>
        <th colspan='5'>Parameter Estimates</th>
      </tr>
      <tr>
        <th>Variable</th><th>Estimate</th><th>Std Error</th><th>T Value</th><th>Prob > T</th>
      </tr>
      <tr> 
         <td>Slope</td> 
         <td align='right'><?php echo $Slope ?></td> 
         <td align='right'><?php echo $SlopeStdErr ?></td>        
         <td align='right'><?php echo $SlopeTVal ?></td>               
         <td align='right'><?php echo $SlopeProb ?></td>                        
      </tr>
      <tr> 
         <td>Intercept</td> 
         <td align='right'><?php echo $YInt ?></td> 
         <td align='right'><?php echo $YIntStdErr ?></td>        
         <td align='right'><?php echo $YIntTVal ?></td>               
         <td align='right'><?php echo $YIntProb ?></td>                                             
      </tr>
    </table>
    <?php
  }

  function showFormula($x_name, $y_name) {    
    $YInt   = sprintf($this->format, $this->YInt);
    $Slope  = sprintf($this->format, $this->Slope);    
    echo "$y_name = $YInt + ($Slope * $x_name)";
  }

  function showRValues() {              
    $R         = sprintf($this->format, $this->R);    
    $RSquared  = sprintf($this->format, $this->RSquared);            
    ?>    
    <table border='1' cellpadding='3'>
      <tr bgcolor='silver'>
        <th colspan='5'>Model Fit</th>
      </tr>    
      <tr>
        <th>R</th><th>R Squared</th>
      </tr>
      <tr> 
         <td align='right'><?php echo $R ?></td> 
         <td align='right'><?php echo $RSquared ?></td>        
      </tr>
    </table>
    <?php
  }

}
?>
