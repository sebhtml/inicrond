<?php
//$Id: linescounter.php 143 2006-08-17 22:34:17Z sebhtml $

foreach($argv AS $key => $argument)
{
	if($argument == "--project")
	{
	$dir = $argv[$key+1];
	
	}
	elseif($argument == "--help")
	{
	echo "
ARGUMENTS

--project <dir_name>

--help
";
	//exit();
	}


}

function count_lines($dir)
{
global $count_tab;

$tmp["tab"] = $count_tab;

$my_tab = "";

while($tmp["tab"] --)
{
$my_tab .= "\t";

}

$dirs_path = explode("/", $dir);

$max = count($dirs_path);

$dir_the_name = $dirs_path[$max];
$my_tab = "";

//echo $my_tab.$dir_the_name."\n";

echo $dir."\n";

$count_tab++;

$count_lines = 0 ;

$dp = openDir($dir);

//echo "$dir\n";

	while($file_name = readDir($dp))
	{
	
	$file_path = $dir."/".$file_name ;
	
		if( $file_name == "." OR 
		$file_name == ".." OR 
		fileSize($file_path) == 0 OR
		$file_name == "CVS"
		)
		{
		
		}
		elseif(is_dir($file_path))
		{
		$count_lines += count_lines($file_path);
		}
		else
		{
		$fp = fopen($file_path, "r");
		$content = fread($fp, fileSize($file_path)) OR die($file_path);
		fclose($fp);
		$array_of_lines = explode("\n", $content);
		
		$count_lines_of_file = count($array_of_lines);
		
		echo $my_tab.$file_path."\t\t$count_lines_of_file\n";
		$count_lines += $count_lines_of_file;
		
		}
	}
closeDir($dp);
	
return $count_lines;
}

$count_tab = 0 ;

//echo $dir."\n";

echo "Total\t\t".count_lines($dir)."\n";



?>