{* Smarty *}

{smarty_array_to_html_function php_array=$course_infos}




<form method="POST">
<br /><br />
{smarty_array_to_html_function php_array=$form_elements}

<input type="submit" name="envoi" />
</form>