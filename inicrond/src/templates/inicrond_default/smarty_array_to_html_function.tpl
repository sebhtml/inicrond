{* Smarty rocks!!!!!!!!!!!! --sebhtml *}
<table cellpadding="4"><tr><td class="table_bg"><table border="0" cellPadding="4">{foreach  name=the_row item=row from=$params.php_array} {* foreach rows *}

<tr class="{if $smarty.foreach.the_row.index == 0}first{elseif $smarty.foreach.the_row.index % 2}by_2{else}not_by_2{/if}">

{foreach item=cell from=$row} {* foreach cells *}

<td>{$cell}</td>

{/foreach}

</tr>

{/foreach}

</table>
</td></tr></table>