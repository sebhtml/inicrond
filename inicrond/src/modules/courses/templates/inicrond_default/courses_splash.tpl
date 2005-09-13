{* Smarty $Id$ *}

{section name=course_index loop=$courses}
{$courses[course_index].cours_code} {$courses[course_index].cours_name}<br />
{/section}