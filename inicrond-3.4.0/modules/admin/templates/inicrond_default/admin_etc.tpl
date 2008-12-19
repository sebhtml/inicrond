{* Smarty $Id: admin_etc.tpl 86 2005-12-29 17:53:10Z sebhtml $ *}

<form method="POST">

{if isset($message)}
<span style="color: red;">{$message}</span>
{/if}

{smarty_array_to_html_function php_array=$the_options}

<input type="submit" name="envoi">
</form>


