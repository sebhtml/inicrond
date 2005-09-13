{* Smarty *}

{smarty_array_to_html_function php_array=$course_infos}


<br /><br />

<a href="../../modules/groups/add_a_group.php?&cours_id={$cours_id}">{$_LANG.add_a_group}</a>

{smarty_array_to_html_function php_array=$course_groups}

