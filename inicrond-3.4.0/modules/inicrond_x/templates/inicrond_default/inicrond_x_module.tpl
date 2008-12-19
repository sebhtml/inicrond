{* Smarty *}

{smarty_array_to_html_function php_array=$course_infos}

<i>{$_LANG.mod_inicrond_x_there_are_the_stats_for_the_groups}</i>
<br />

{$groups_listing}

<br /><br />
{smarty_array_to_html_function php_array=$usrs_statistics}

