{* Smarty *}

{* $Id$ *}

{smarty_array_to_html_function php_array=$course_infos}


 <fieldset>
    <legend><b>{$_LANG.administrators}</b>
  {if isset($course.admin_grps)}
({$course.admin_grps})
{/if}</legend>



{section name=group loop=$big_array.administrators}

<a href="{$big_array.administrators[group].group_link}">{$big_array.administrators[group].group_name}</a> ({$big_array.administrators[group].edit_link})
        <table>
        {section name=user loop=$big_array.administrators[group].users}
<tr><td>
<a href="{$big_array.administrators[group].users[user].usr_link}">{$big_array.administrators[group].users[user].usr_name}</a></td><td> {$big_array.administrators[group].users[user].usr_nom}</td><td> {$big_array.administrators[group].users[user].usr_prenom}</td></tr>

        {/section}
        </table>
{/section}
<hr />

</fieldset>
 <fieldset>
 <legend><b>{$_LANG.students}</b>
 {if $course.stu_grps != ""} ({$course.stu_grps}) {/if}</legend>




<table border="0" cellSpacing="5" cellPadding="5">
{section name=group loop=$big_array.students}
<tr>
<td colspan="2" align="left">
<b>{$big_array.students[group].group_name} </b> ({$big_array.students[group].edit_group_link})<br /><i>
{$big_array.students[group].count_users} {$_LANG.persons}</i>
</td></tr>
<tr>
<td align="left" valign="top">

<table>
        {section name=user loop=$big_array.students[group].users}
<tr><td >
<a href="{$big_array.students[group].users[user].usr_link}">{$big_array.students[group].users[user].usr_name}</a></td><td ><u>{$big_array.students[group].users[user].usr_nom}</u></td><td> {$big_array.students[group].users[user].usr_prenom}</td></tr>



        {/section}
</table>

</td>
<td valign="top">


{if isset ($big_array.students[group].groups_in_charge) && !count($big_array.students[group].groups_in_charge)}
{$_LANG.no_groups_are_in_charge_of_this_group_course}
{else}
<b>{$_LANG.groups_in_charge_of_this_group}</b>
{/if}

{if $big_array.students[group].change_charge_link != ""}
(<a href="{$big_array.students[group].change_charge_link}">{$_LANG.modify}</a>)
{/if}

<br /><br />

{if isset ($big_array.students[group].groups_in_charge)}

{/if}
{section name=group2 loop=$big_array.students[group].groups_in_charge}

{$big_array.students[group].groups_in_charge[group2].group_name} ({$big_array.students[group].groups_in_charge[group2].edit_group_link})

<table border="0">
        {section name=user loop=$big_array.students[group].groups_in_charge[group2].users}
<tr><td>
<a href="{$big_array.students[group].groups_in_charge[group2].users[user].usr_link}">{$big_array.students[group].groups_in_charge[group2].users[user].usr_name}</a></td><td>{$big_array.students[group].groups_in_charge[group2].users[user].usr_nom}</td><td> {$big_array.students[group].groups_in_charge[group2].users[user].usr_prenom}</td></tr>



        {/section}

</table>
<hr />

{/section}







</td>
</tr>
<tr>
<td colspan="2"><hr /></td></tr>
{/section}
</fieldset>

</table>