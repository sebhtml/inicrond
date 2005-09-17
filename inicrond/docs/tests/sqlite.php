<?php
//$Id$


$db = sqlite_open("database.sql");


sqlite_query($db, "DROP TABLE  try_it_on" );

sqlite_query($db, "CREATE TABLE try_it_on (
id BITINT,
name TEXT

)

" );

sqlite_query($db, "INSERT INTO try_it_on (id, name) VALUES (2, 'kakao');" );

$r = sqlite_query($db, "SELECT * FROM try_it_on;" );

while($f = sqlite_fetch_array( $r))
{
print_r($f);

}
?>