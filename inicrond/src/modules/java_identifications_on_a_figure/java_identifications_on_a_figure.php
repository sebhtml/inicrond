<?php

if(!isset($_POST['width']))
{

echo '
<form method="POST" enctype="multipart/form-data">

width : <input type="text" name="width" value="700" /><br />
height : <input type="text" name="height" value="550" /><br />

title_file : <input type="file" name="title_file"  /><br />
arrows_location_file : <input type="file" name="arrows_location_file"  /><br />
image_file : <input type="file" name="image_file"  /><br />
button_names_file : <input type="file" name="button_names_file"  /><br />




<input type="submit" />

';

}
else
{



copy($_FILES['title_file']['tmp_name'], $_FILES['title_file']['name']);
copy($_FILES['arrows_location_file']['tmp_name'], $_FILES['arrows_location_file']['name']);
copy($_FILES['image_file']['tmp_name'], $_FILES['image_file']['name']);
copy($_FILES['button_names_file']['tmp_name'], $_FILES['button_names_file']['name']);

echo '
<html>
        <body>
        <applet code="Identification_img.class" width="'.$_POST['width'].'" height="'.$_POST['height'].'" >
        <PARAM NAME="width" VALUE="'.$_POST['width'].'" />
        <PARAM NAME="height" VALUE="'.$_POST['height'].'" />
        <PARAM NAME="title_file" VALUE="'.$_FILES['title_file']['name'].'" />
        <PARAM NAME="arrows_location_file" VALUE="'.$_FILES['arrows_location_file']['name'].'" />
        <PARAM NAME="image_file" VALUE="'.$_FILES['image_file']['name'].'" />
        <PARAM NAME="button_names_file" VALUE="'.$_FILES['button_names_file']['name'].'" />
        </applet>
        </body>

</html>

';
}

?>
