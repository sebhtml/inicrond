<?php


function smarty_reduce_html_size($tpl_source, &$smarty)
{

$tpl_source = str_replace("\n", '', $tpl_source);//remove the new lines
$tpl_source = str_replace("\t", '', $tpl_source);//remove the tabulations
$tpl_source = preg_replace('/[ ]{2,}/', ' ', $tpl_source);//replace 2 or more space by one space

return $tpl_source;
}








?>