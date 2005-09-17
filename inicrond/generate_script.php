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

//here I open src and foreach dir that containt .php file, I add a line
//indent_files_in_dir absolute_dir

//here I write the file named script.sh







?>