<?php
//I define the function.
$content = 
"
indent_files_in_dir()
{
cd $1 #go to the asked directory

indent -gnu-style *.php #indent stuff

perl -p -i -e 's/^< \? php$/<?php/g' *.php #change < ? php to <?php
perl -p -i -e 's/^\? >$/?>/g' *.php #	change ? > to ?>
perl -p -i -e 's/\. =/ .= /g' *.php #	. = to .=


rm *~ #remove those ugly files
}


";
 $root_dir = getcwd().'/';

//here I open src and foreach dir that containt .php file, I add a line
//indent_files_in_dir absolute_dir

 $php_directories = array();
function get_all_php_directories($dir)
{
global $php_directories;

$fp = opendir($dir);
while($file_name = readdir($fp))
{
    if($file_name == '.' || $file_name == '..')
    {
    continue;
  
    }
    elseif(strstr($file_name, 'php'))//is probably a php file.
    {
        $php_directories [$dir]= $dir;//I use the key to avoid doubles
    
    }
    elseif(is_dir($dir.$file_name))
    {
    get_all_php_directories($dir.$file_name.'/');
    
    }
}
closedir($fp);




}


get_all_php_directories($root_dir.'src/modules/');
get_all_php_directories($root_dir.'src/includes/');

//echo $root_dir ;

foreach($php_directories as $directory)
{

$content .= "indent_files_in_dir $directory
";



}
//here I write the file named script.sh


$fp = fopen('script.sh', 'w+');
fwrite($fp, $content);
fclose($fp);





?>