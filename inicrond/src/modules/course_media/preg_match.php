<?php
//header("Content-type: application/xhtml+xml")

//$Id$


session_start();
/*
if(isset($HTTP_RAW_POST_DATA))
{
        $_SESSION["my_xml"] = $HTTP_RAW_POST_DATA;
}
*/
//it is better to use the php://input url wrapper

if(isset($_GET["debug"]))
{
        echo $_SESSION["my_xml"];
        
        echo "end of RAW XML\n";
}

$fp = fopen("php://input", "r");
$_SESSION["my_xml"] = fread($fp, 2048);
fclose($fp);


$xml_parser = xml_parser_create();



$data =$_SESSION["my_xml"];

xml_parse_into_struct($xml_parser, $data, $vals, $index);
xml_parser_free($xml_parser);

echo "<XML>";

$score = 0;
foreach($index["PREG_EXP"] AS $key => $value)

{
        echo "<ELEMENT>";
        //echo " ".$vals[$index["PREG_EXP"][$key]]["value"]." ".$vals[$index["STRING_ANALYSIS"][$key]]["value"]."<br />";
        $score =  preg_match($vals[$index["PREG_EXP"][$key]]["value"], $vals[$index["STRING_ANALYSIS"][$key]]["value"]) ? 1 : 0;
        echo "<SCORE>".$score."</SCORE>";
        echo "</ELEMENT>";
        
	if(isset($_GET["debug"]))
	{
                echo "exp =".$vals[$index["PREG_EXP"][$key]]["value"].", ";
		echo "string =".$vals[$index["STRING_ANALYSIS"][$key]]["value"].", ";
		
                echo "value =".$score.", ";
                
	}
}

//print_r($vals);
//print_r($index);
echo "</XML>";

?>