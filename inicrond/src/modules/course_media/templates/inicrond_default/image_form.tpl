{* Smarty *}


<form method="POST" enctype="multipart/form-data">

{$_LANG.img_title} : <input type="text" name='img_title' value="{$img_title}" /><br />

{$_LANG.img_description} : <textarea name='img_description'>{$img_description}</textarea><br />

{$_LANG.img_file_name} : <input type='file' name='img_file_name'  /><br />




<input type="submit" />

</form>

