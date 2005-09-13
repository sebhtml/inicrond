{* Smarty *}
{* Using Smarty is cool... *}
{* $Id$ *}

{smarty_array_to_html_function php_array=$cours}

<i>{$search_forums}</i><br />

{$add_section_link}
<table cellpadding="4"><tr><td class="table_bg">
<table width="100%" border="0" cellpadding="2" cellspacing="1">
{ * title *}
<tr class="first">
	<td align="center">
	<b>{$forum_title}</b>
	</td>
	<td align="center">
	<b>{$nb_post_title}</b>
	</td>
	<td  align="center">
	<b>{$nb_thread_title}</b>
	</td>
	<td  align="center" >
	<b>{$last_post_title}</b>
	</td>
</tr>

{section name=section loop=$sections}
<tr class="first">
	<td colspan="4" align="center" >
	{$sections[section].title}
	
	{if $sections[section].edit_link != ""}
	<br />{$sections[section].edit_link}
	{/if}
	{if $sections[section].up_link != ""}
	<br />{$sections[section].up_link}
	{/if}
	{if $sections[section].down_link != ""}
	<br />{$sections[section].down_link}
	{/if}
	{if $sections[section].add_forum_link != ""}
	<br />{$sections[section].add_forum_link}
	{/if}
	{if $sections[section].rm_link != ""}
	<br />{$sections[section].rm_link}
	{/if}
	{if $sections[section].section_viewers != ""}
	<br />{$sections[section].section_viewers}
	{/if}
	
	{if $sections[section].section_admin != ""}
	<br />{$sections[section].section_admin}
	{/if}
	
	</td>
	{section name=forum loop=$sections[section].forums}
	<tr class="{cycle values="by_2,not_by_2"}">
		<td >
		{$sections[section].forums[forum].link}
		<br />{$sections[section].forums[forum].description}
		
		{if $sections[section].forums[forum].edit != ""}
		<br />{$sections[section].forums[forum].edit}
		{/if}
		{if $sections[section].forums[forum].rm != ""}
		<br />{$sections[section].forums[forum].rm}
		{/if}
		{if $sections[section].forums[forum].up != ""}
		<br />{$sections[section].forums[forum].up}
		{/if}
		{if $sections[section].forums[forum].down != ""}
		<br />{$sections[section].forums[forum].down}
		{/if}
		{if $sections[section].forums[forum].viewers != ""}
		<br />{$sections[section].forums[forum].viewers}
		{/if}
		{if $sections[section].forums[forum].moderators != ""}
		<br />{$sections[section].forums[forum].moderators}
		{/if}
		{if $sections[section].forums[forum].reply_ppl != ""}
		<br />{$sections[section].forums[forum].reply_ppl}
		{/if}
		{if $sections[section].forums[forum].starters != ""}
		<br />{$sections[section].forums[forum].starters}
		{/if}
		</td>	
		<td  align="center">
		{$sections[section].forums[forum].nb_posts}
		</td>
		<td  align="center">
		{$sections[section].forums[forum].nb_threads}
		</td>
		<td  align="center">
		{$sections[section].forums[forum].last_post}<br />
		{$sections[section].forums[forum].last_poster}
		</td>
	</tr>	
	{/section}


</tr>	
{/section}
</table>
</td></tr></table>