{* Smarty *}

<form method="POST" action="smarty_cache_config.php">

{* all module directories *}
<table border="0" cellSpacing="5" cellSpacing="5">

{foreach key=key item=mod_dir from=$settings}

<tr><td colspan="2"><h1>{$_LANG[$key]} ({$key})</h1></td></tr>


<tr>
<td>&nbsp;


	{* modules *}
<table>
{foreach key=key2  item=element   from=$settings[$key]}
	
	
	{* drop list *}	
<tr><td>
{$settings[$key][$key2].tpl_file}</td><td>
{$settings[$key][$key2].drop_list}	</td></tr>
	
	{/foreach}
	</table>
	</td>
	<td>&nbsp;
	
	

</td>
</tr>


{/foreach}
</table>
<input type="submit" name="data_is_sent">
</form>