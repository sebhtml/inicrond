{* Smarty $Id$ *}

<form method="POST">

{if $message != ""}
<span style="color: red;">{$message}</span>
{/if}

{smarty_array_to_html_function php_array=$the_options}

<input type="submit" name="envoi">
</form>


