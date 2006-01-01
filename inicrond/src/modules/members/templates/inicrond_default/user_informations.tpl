{* Smarty *}

{* $Id$ *}

<table><tr><td><h1>{$usr.usr_name}</h1></td><td>{$usr.img}</td></tr></table>

<br />


{$usr.usr_prenom} {$usr.usr_nom}<br />

{$_LANG.usr_add_gmt_timestamp} : {$usr.usr_add_gmt_timestamp}<br />

{if $usr.usr_number != ""}
{$_LANG.usr_number} : {$usr.usr_number}<br />
{/if}

{if $usr.usr_email != ""}
{$usr.usr_email}<br />
{/if}



{$usr.usr_signature}<br />

{if $usr.seSSi != ""}
<h3>{$_LANG.data}</h3>
{$usr.seSSi}, {$usr.marks}, {$usr.tests_results}, {$usr.dl_acts_4_courses}
{/if}

{if isset ($usr.user_graphics_for_a_course)}
, {$usr.user_graphics_for_a_course}
{/if}
<br />


{if $usr.courses_list_for_a_user[0] != ""}

<h3>{$_LANG.courses_list_for_a_user}</h3>

<ul>
{section name=entry loop=$usr.courses_list_for_a_user}
<li>{$usr.courses_list_for_a_user[entry]}</li>
{/section}

</ul>

{/if}

{if isset ($usr.change_grps_for_usr)}
<h3>{$_LANG.admin}</h3>
{$usr.change_grps_for_usr}<br />

{$usr.login_as}<br />
{/if}