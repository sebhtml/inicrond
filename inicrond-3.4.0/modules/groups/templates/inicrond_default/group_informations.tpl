{* Smarty *}

{* $Id: group_informations.tpl 127 2006-01-28 21:50:33Z sebhtml $ *}

{smarty_array_to_html_function php_array=$course_infos}
<h3>{$_LANG.group_informations}</h3>

{$group.group_name}<br />
{$group.add_time_t} <br />
{$_LANG.default_pending} : {$group.default_pending}<br />

<h3>{$_LANG.data}</h3>
{$group.get_group_emails}, {$group.seSSi}, {$group.marks}, {$group.tests_results}, {$group.dl_acts_4_courses}, {$group.graphics_for_a_group} <br />

<h3>{$_LANG.admin}</h3>
{$group.edit}, {$group.remove_group}, {$group.update_group_password}, {$group.course_groups_listing}, {$group.divide_a_group}<br />

<h3>{$_LANG.count_stuff_for_a_group}</h3>

{$count_stuff_for_a_group}

<h3>{$_LANG.group_users}</h3>

<table>
{section name=user loop=$group.users}
<tr>
<td> {$group.users[user].usr_nom} </td>
<td> {$group.users[user].usr_prenom} </td>
<td> <a href="{$group.users[user].usr_link}">{$group.users[user].usr_name} </a>

  </td>
<td> <a href="{$group.users[user].remove_user_link}">{$_LANG.remove}</a> </td>


</tr>
{/section}
</table>
