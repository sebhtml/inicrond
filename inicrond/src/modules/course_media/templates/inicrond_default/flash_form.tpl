{* Smarty *}


<form method="POST" enctype="multipart/form-data">

{$_LANG.chapitre_media_title} : <input type="text" name='chapitre_media_title' value="{$chapitre_media_title}" /><br />

{$_LANG.chapitre_media_description} : <textarea name='chapitre_media_description'>{$chapitre_media_description}</textarea><br />

{$_LANG.file_name} : <input type='file' name='file_name'  /><br />




<input type="submit" />

</form>

