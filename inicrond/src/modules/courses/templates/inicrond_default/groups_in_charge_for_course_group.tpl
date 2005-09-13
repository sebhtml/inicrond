{* Smarty *}
{* $Id$ *}

{$_LANG.cours_name} : {$smarty_array.cours_name}<br />
{$_LANG.group_name} : {$smarty_array.group_name}<br />
<br />
<table cellSpacing="5">
<tr>
	<td>
	<b>{$_LANG.groups_not_in_charge_of_this_group}</b>
	</td>
	
	<td>
	<b>{$_LANG.groups_in_charge_of_this_group}</b>
	</td>
	
</tr>
<tr>
	<td>
	{section name=entry loop=$smarty_array.not_in_charge_groups}
	
		{$smarty_array.not_in_charge_groups[entry]}<br />
		
	{/section}
	</td>
	
	<td>
	{section name=entry loop=$smarty_array.in_charge_groups}
	
		{$smarty_array.in_charge_groups[entry]}<br />
		
	{/section}
	</td>
	
</tr>
</table>

