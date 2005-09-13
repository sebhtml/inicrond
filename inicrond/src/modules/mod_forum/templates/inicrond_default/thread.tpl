{* Smarty *}
{* $Id$ *}

{smarty_array_to_html_function php_array=$cours}


<h3>{$forums_link}</h3>

<h3>{$forum_link}</h3>
	   
{section name=post loop=$posts}
{$posts[post].post_anchor}


<table width="100%" border="0" cellPadding="4">
<tr >



	{* the blank thing * }
	<td  >{$posts[post].the_great_space_ship_commander}</td>
	<td>
	<table  width="100%" cellpadding="4"><tr><td class="table_bg">
	<table  width="100%" cellpadding="4"><tr class="first">
	<td width="100%" valign="top" >
		
			
			<table width="100%">
			<tr>
			<td>
			{$posts[post].usr_picture}
		</td>
		
		<td>
		
			</td>
			<td width="100%">
		<h2>{$posts[post].post_title}</h2>
		{$_LANG.by} {$posts[post].usr_link}<br />

		</td>
			<td >
			{if $posts[post].edit_link != ""}
			({$posts[post].edit_link})
			{/if}
			
			</td>
			</tr>
			</table>
		
	</td>
	</tr>
	<tr  class="{cycle values="by_2,not_by_2"}">
	<td  valign="top">
	
	

		
		{$posts[post].post_content}<br />
		{$posts[post].usr_signature}<br />
		<table width="100%">
			<tr>
			<td  width="100%">
			<small><i>
		{$posts[post].post_add_time}<br />
		
		{if $posts[post].post_edit_time != ""}
		{$posts[post].post_edit_time}<br />
		{/if}
		
		{$_LANG.thread} # {$posts[post].forum_sujet_id}<br />
		{$_LANG.post} # {$posts[post].forum_message_id}<br /> 
		{$_LANG.reply_to_post} # {$posts[post].forum_message_id_reply_to}
		</i></small>
		</td>
		<td valign="bottom">
		
		{if $posts[post].reply_link != ""}
		<a href={$posts[post].reply_link}>{$_LANG.reply}</a>
		{/if}
		
		</td>
			</tr>
			</table>
		</tr></table>
		</td></tr></table>
	
	</td>
	


</tr>	
</table>

<br />
{/section}

<a href="{$move_thread_link}">{$_LANG.changer_de_discussion}</a><br />
<a href="{$lock_thread_link}">{$_LANG.close_open}</a><br />

