{* Smarty $Id$ *}

{smarty_array_to_html_function php_array=$cours}


{$forums_link}

{if $start_a_thread_url != ""}
<a href="{$start_a_thread_url}">{$_LANG.start}</a><br />
{/if}

{smarty_array_to_html_function php_array=$threads}
	
