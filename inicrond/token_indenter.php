<?php

$file = '/home/sebhtml/public_html/inicrond/src/modules/members/members.php';
$fp = fopen($file, 'r');
$array = token_get_all(fread($fp, filesize($file)));
fclose($fp);
print_r($array);




?>