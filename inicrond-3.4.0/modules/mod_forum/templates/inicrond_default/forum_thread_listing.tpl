{* Smarty $Id: forum_thread_listing.tpl 8 2005-09-13 17:44:21Z sebhtml $ *}

{smarty_array_to_html_function php_array=$cours}


{$forums_link}

{if $start_a_thread_url != ""}
<a href="{$start_a_thread_url}">{$_LANG.start}</a><br />
{/if}

{smarty_array_to_html_function php_array=$threads}
	
