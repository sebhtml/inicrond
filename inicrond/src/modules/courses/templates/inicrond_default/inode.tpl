
{* Smarty *}

{* $Id$ *}

{smarty_array_to_html_function php_array=$course_infos}

{if isset ($requested_path)}
    <h3>{$requested_path}</h3><br />
{/if}

{if !isset ($parent_dir)}

{$course.cours_description}<br />



 {if isset ($calendar)}
 {$calendar}<br />
 {/if}

 {if isset ($course.inicrond_x_module)}
 {$course.inicrond_x_module}<br />
 {/if}

 {if isset ($course.see_online_people_for_a_course)}
 {$course.see_online_people_for_a_course}<br />
{/if}

 {if isset ($course_admin_menu)}
 {$course_admin_menu}<br />
{/if}

{$blue_master_clone}<br />




<a href="{$course.forums_link}">{$_LANG.mod_forum}</a><br />


{if isset ($course_users)}
{$course_users}<br />
{/if}

{if isset ($course_groups_listing)}
{$course_groups_listing}<br />
{/if}

{if isset ($course.edit)}
    {$course.edit}  <br />
{/if}

{if isset ($course.drop)}
    {$course.drop}
{/if}

{/if}

<br /><br />
{* beginning of dir listing *}

{if !isset ($add_dir) OR count($dirs_list) > 0}


<b>{$_LANG.dirs_list} </b>

{if isset ($add_dir)}
<a href="{$add_dir}"><img  src="templates/inicrond_default/images/b_newdb.png" title="{$_LANG.add}" border="0" /></a>
{/if}

<br /><br />

{* parent dir link *}

{if isset ($parent_dir)}
<a href="{$parent_dir}"><img  border="0" src="templates/inicrond_default/images/parent.gif" /></a><br />

{/if}

{section name=dir loop=$dirs_list}

<img  src="templates/inicrond_default/images/folder.gif" border="0"/> {$dirs_list[dir].link}

 {if isset ($course_admin_menu)}


<a href="{$dirs_list[dir].edit}" ><img  border="0" title="{$_LANG.edit}" src="templates/inicrond_default/images/b_edit.png" /></a>

<a href="{$dirs_list[dir].drop}"  ><img  border="0" title="{$_LANG.remove}" src="templates/inicrond_default/images/b_drop.png" /></a>

<a href="{$dirs_list[dir].inode_up}" ><img  border="0" title="{$_LANG.inode_up}" src="templates/inicrond_default/images/inode_up.png" /></a>

<a href="{$dirs_list[dir].inode_down}" ><img  border="0" title="{$_LANG.inode_down}" src="templates/inicrond_default/images/inode_down.png" /></a>

<a href="inode_groups.php?&inode_id={$dirs_list[dir].inode_id}" ><img  border="0" title="{$_LANG.authorized_groups}" src="templates/inicrond_default/images/group.gif" /></a>

<a href="inode_location.php?&inode_id={$dirs_list[dir].inode_id}" ><img  border="0" title="{$_LANG.inode_location}" src="templates/inicrond_default/images/inode_location.gif" /></a>
{/if}

<br />
{/section}

<br />

{* end of dir listing *}
{/if}

{if isset ($add_file ) || count($mod_files) > 0}



<b>{$_LANG.mod_files} </b>
{if isset ($add_file)}
<a href="{$add_file}"><img  border="0" src="templates/inicrond_default/images/b_newdb.png" /></a>
{/if}
<br /><br />

{section name=file loop=$mod_files}

<table width="100%"><tr><td class="inode_element">
{* a file template *}
<table><tr><td>
<img  border="0" src="templates/inicrond_default/images/enregistrer.gif" />

 </td><td>


<table>

<tr><td><b>{$_LANG.title}</b></td><td> {$mod_files[file].link}

{if isset ($mod_files[file].edit)}
<a href="{$mod_files[file].edit}"><img  border="0"  title="{$_LANG.edit}" src="templates/inicrond_default/images/b_edit.png" /></a>
{/if}


{if isset ($mod_files[file].drop)}
<a href="{$mod_files[file].drop}" ><img  border="0" title="{$_LANG.remove}" src="templates/inicrond_default/images/b_drop.png" /></a>
{/if}

{if isset ($mod_files[file].dl_acts)}
<a href="{$mod_files[file].dl_acts}" ><img  border="0" title="{$_LANG.dl_acts_4_courses}" src="templates/inicrond_default/images/download_acts.png" /></a>
{/if}

{if isset ($mod_files[file].dl_report)}
<a href="{$mod_files[file].dl_report}" ><img  border="0" title="{$_LANG.group_downloads_reporting}" src="templates/inicrond_default/images/dl_report.png" /></a>
{/if}




{if isset ($mod_files[file].inode_up)}
<a href="{$mod_files[file].inode_up}" ><img  border="0" title="{$_LANG.inode_up}" src="templates/inicrond_default/images/inode_up.png" /></a>
{/if}

{if isset ($mod_files[file].inode_down)}
<a href="{$mod_files[file].inode_down}" ><img  border="0" title="{$_LANG.inode_down}" src="templates/inicrond_default/images/inode_down.png" /></a>
{/if}

 {if isset ($course_admin_menu)}
<a href="inode_groups.php?&inode_id={$mod_files[file].inode_id}" ><img  border="0" title="{$_LANG.authorized_groups}" src="templates/inicrond_default/images/group.gif" /></a>

<a href="inode_location.php?&inode_id={$mod_files[file].inode_id}" ><img  border="0" title="{$_LANG.inode_location}" src="templates/inicrond_default/images/inode_location.gif" /></a>
{/if}

<b>{$mod_files[file].my_results_link}</b>
</td></tr>

<tr><td><b>{$_LANG.file_name}</b></td><td>{$mod_files[file].file_name}</td></tr>
<tr><td><b>{$_LANG.description}</b></td><td>{$mod_files[file].file_infos}</td></tr>
<tr><td><b>{$_LANG.filesize}</b></td><td>{$mod_files[file].filesize}</td></tr>
{* <tr><td><b>{$_LANG.md5_sum}</b></td><td>{$mod_files[file].md5_sum}</td></tr> *}
<tr><td><b>{$_LANG.add_gmt}</b></td><td>{$mod_files[file].add_gmt}</td></tr>
<tr><td><b>{$_LANG.edit_gmt}</b></td><td>{$mod_files[file].edit_gmt}</td></tr>
</table>

</td></tr></table>
</td></tr></table><br />

{/section}

{/if}

{if isset ($add_test) || count($tests) > 0}

<b>{$_LANG.formative_tests} </b>


{if isset ($add_test)}
<a href="{$add_test}"><img  border="0" src="templates/inicrond_default/images/b_newdb.png" /></a>
{/if}

<br /><br />

{section name=test loop=$tests}
<table width="100%"><tr><td class="inode_element">

<img  border="0" src="templates/inicrond_default/images/checked.gif" /> {$tests[test].link}


{if isset ($tests[test].edit)}
<a href="{$tests[test].edit}" ><img  border="0" title="{$_LANG.edit}" src="templates/inicrond_default/images/b_edit.png" /></a>

<a href="{$tests[test].edit_a_test_GOLD}" ><img  border="0" title="{$_LANG.edit}" src="templates/inicrond_default/images/edit_a_test_GOLD.gif" /></a>
{/if}

{if isset ($tests[test].drop)}
<a href="{$tests[test].drop}"><img  border="0"  title="{$_LANG.remove}" src="templates/inicrond_default/images/b_drop.png" /></a>
{/if}

{if isset ($tests[test].scores)}
<a href="{$tests[test].scores}"><img  border="0"  title="{$_LANG.results}" src="templates/inicrond_default/images/download_acts.png" /></a>
{/if}

{if isset ($tests[test].report)}
<a href="{$tests[test].report}"><img  border="0"  title="{$_LANG.test_activities_report}" src="templates/inicrond_default/images/dl_report.png" /></a>
{/if}

{if isset ($tests[test].mass_update)}
<a href="{$tests[test].mass_update}"><img  border="0"  title="{$_LANG.update_test_results}" src="templates/inicrond_default/images/mass_correct.gif" /></a>
{/if}
{if isset ($tests[test].inode_up)}
<a href="{$tests[test].inode_up}" ><img  border="0" title="{$_LANG.inode_up}" src="templates/inicrond_default/images/inode_up.png" /></a>
{/if}

{if isset ($tests[test].inode_down)}
<a href="{$tests[test].inode_down}" ><img  border="0" title="{$_LANG.inode_down}" src="templates/inicrond_default/images/inode_down.png" /></a>
{/if}

 {if isset ($course_admin_menu)}
<a href="inode_groups.php?&inode_id={$tests[test].inode_id}" ><img  border="0" title="{$_LANG.authorized_groups}" src="templates/inicrond_default/images/group.gif" /></a>

<a href="inode_location.php?&inode_id={$tests[test].inode_id}" ><img  border="0" title="{$_LANG.inode_location}" src="templates/inicrond_default/images/inode_location.gif" /></a>
{/if}

{if isset ($tests[test].my_results_link)}
<b><a href="{$tests[test].my_results_link}" >{$_LANG.my_results}</a></b>
{/if}



<br />

{$_LANG.test_info} : {$tests[test].test_info}<br />
{$_LANG.add_gmt} : {$tests[test].time_GMT_add}<br />
{$_LANG.edit_gmt} : {$tests[test].time_GMT_edit}<br />




</td></tr></table><br />

{/section}
<br />
{/if}


{if isset ($add_swf) || count($anims) > 0}
{* flash animations *}
<b>{$_LANG.animations} </b>

{if isset ($add_swf)}
<a href="{$add_swf}"><img  border="0" src="templates/inicrond_default/images/b_newdb.png" /></a>
{/if}


<br /><br />

{section name=anim loop=$anims}
<table width="100%"><tr><td class="inode_element">
<img  border="0" src="templates/inicrond_default/images/flash.gif" /> {$anims[anim].link}




{if isset ($anims[anim].edit)}
<a href="{$anims[anim].edit}" ><img  border="0" title="{$_LANG.edit}" src="templates/inicrond_default/images/b_edit.png" /></a>
{/if}

{if isset ($anims[anim].drop)}
<a href="{$anims[anim].drop}" ><img  border="0" title="{$_LANG.remove}" src="templates/inicrond_default/images/b_drop.png" /></a>
{/if}

{if isset ($anims[anim].marks)}
<a href="{$anims[anim].marks}" ><img  border="0" title="{$_LANG.marks}" src="templates/inicrond_default/images/download_acts.png" /></a>
{/if}

{if isset ($anims[anim].report)}
<a href="{$anims[anim].report}" ><img  border="0" title="{$_LANG.flash_activities_report}" src="templates/inicrond_default/images/dl_report.png" /></a>
{/if}

{if isset ($anims[anim].inode_up)}
<a href="{$anims[anim].inode_up}" ><img  border="0" title="{$_LANG.inode_up}" src="templates/inicrond_default/images/inode_up.png" /></a>
{/if}

{if isset ($anims[anim].inode_down)}
<a href="{$anims[anim].inode_down}" ><img  border="0" title="{$_LANG.inode_down}" src="templates/inicrond_default/images/inode_down.png" /></a>
{/if}

 {if isset ($course_admin_menu)}

<a href="inode_groups.php?&inode_id={$anims[anim].inode_id}" ><img  border="0" title="{$_LANG.authorized_groups}" src="templates/inicrond_default/images/group.gif" /></a>

<a href="inode_location.php?&inode_id={$anims[anim].inode_id}" ><img  border="0" title="{$_LANG.inode_location}" src="templates/inicrond_default/images/inode_location.gif" /></a>

{/if}
{if isset ($anims[anim].my_results_link)}
<b><a href="{$anims[anim].my_results_link}" >{$_LANG.my_results}</a></b>
{/if}

<br />
{$_LANG.file_name} : {$anims[anim].file_name}<br />
{$_LANG.description} : {$anims[anim].chapitre_media_description}<br />



{$_LANG.add_gmt} : {$anims[anim].chapitre_media_add_gmt_timestamp}<br />
{$_LANG.edit_gmt} : {$anims[anim].chapitre_media_edit_gmt_timestamp}<br />



</td></tr></table><br />
{/section}


{/if}


<br />
{if isset ($add_img) || count($images) > 0}
<b>{$_LANG.images} </b>
{if isset ($add_img)}
<a href="{$add_img}"><img  border="0" src="templates/inicrond_default/images/b_newdb.png" /></a>
{/if}
<br /><br />

{section name=one loop=$images}
<table width="100%"><tr><td class="inode_element">

<img  border="0" src="templates/inicrond_default/images/preview.gif" />

{$images[one].title}

{if isset ($images[one].edit)}
<a href="{$images[one].edit}" ><img  border="0" title="{$_LANG.edit}" src="templates/inicrond_default/images/b_edit.png" /></a>
{/if}

{if isset ($images[one].drop)}
<a href="{$images[one].drop}" ><img  border="0"  title="{$_LANG.remove}" src="templates/inicrond_default/images/b_drop.png" /></a>
{/if}

{if isset ($images[one].inode_up)}
<a href="{$images[one].inode_up}"><img  border="0"  title="{$_LANG.inode_up}" src="templates/inicrond_default/images/inode_up.png" /></a>
{/if}

{if isset ($images[one].inode_down)}
<a href="{$images[one].inode_down}" ><img  border="0" title="{$_LANG.inode_down}" src="templates/inicrond_default/images/inode_down.png" /></a>



<a href="inode_groups.php?&inode_id={$images[one].inode_id}" ><img  border="0" title="{$_LANG.authorized_groups}" src="templates/inicrond_default/images/group.gif" /></a>

<a href="inode_location.php?&inode_id={$images[one].inode_id}" ><img  border="0" title="{$_LANG.inode_location}" src="templates/inicrond_default/images/inode_location.gif" /></a>
{/if}

<br />

<table>
<tr>
        <td valign="top">
        <img src="{$images[one].img_url}"><br />

        </td>
        <td valign="top">
        <table>

<tr><td>{$_LANG.file_name}</td><td>{$images[one].file_name}</tr>
<tr><td>{$_LANG.description}</td><td>{$images[one].chapitre_media_description}</tr>



<tr><td>{$_LANG.add_gmt}</td><td>{$images[one].chapitre_media_add_gmt_timestamp}</tr>
<tr><td>{$_LANG.edit_gmt}</td><td>{$images[one].chapitre_media_edit_gmt_timestamp}</tr>
         </table> </td></tr></table>

</td></tr></table><br />
{/section}

<br />

{/if}





{if isset ($add_text) || count($texts) > 0}
<b>{$_LANG.texts} </b>
{if isset ($add_text)}
<a href="{$add_text}"><img  border="0" src="templates/inicrond_default/images/b_newdb.png" /></a>
{/if}
<br /><br />

{section name=one loop=$texts}
<table width="100%"><tr><td class="inode_element">

<img  border="0" src="templates/inicrond_default/images/txt.gif" /> {$texts[one].title}
{if isset ($texts[one].edit)}
<a href="{$texts[one].edit}" ><img  border="0" title="{$_LANG.edit}" src="templates/inicrond_default/images/b_edit.png" /></a>
{/if}

{if isset ($texts[one].drop)}
<a href="{$texts[one].drop}" ><img  border="0" title="{$_LANG.remove}" src="templates/inicrond_default/images/b_drop.png" /></a>
{/if}

{if isset ($texts[one].inode_up)}
<a href="{$texts[one].inode_up}" ><img  border="0" title="{$_LANG.inode_up}" src="templates/inicrond_default/images/inode_up.png" /></a>
{/if}

{if isset ($texts[one].inode_down)}
<a href="{$texts[one].inode_down}" ><img  border="0" title="{$_LANG.inode_down}" src="templates/inicrond_default/images/inode_down.png" /></a>

<a href="inode_groups.php?&inode_id={$texts[one].inode_id}" ><img  border="0" title="{$_LANG.authorized_groups}" src="templates/inicrond_default/images/group.gif" /></a>

<a href="inode_location.php?&inode_id={$texts[one].inode_id}"><img  border="0"  title="{$_LANG.inode_location}" src="templates/inicrond_default/images/inode_location.gif" /></a>
{/if}

<br />


{$_LANG.description} : {$texts[one].chapitre_media_description}<br />



{$_LANG.add_gmt} : {$texts[one].chapitre_media_add_gmt_timestamp}<br />
{$_LANG.edit_gmt} : {$texts[one].chapitre_media_edit_gmt_timestamp}<br />


</td></tr></table><br />
{/section}

{/if}

{*
    java_identifications_on_a_figure
*}

{if isset ($add_a_java_identifications_on_a_figure) || count ($java_identifications_on_a_figure) > 0}

<h2>{$_LANG.java_identifications_on_a_figure}</h2>

    {if isset ($add_a_java_identifications_on_a_figure)}

        <a href="{$add_a_java_identifications_on_a_figure}">
            <img src="templates/inicrond_default/images/b_newdb.png" title="{$_LANG.add_a_java_identifications_on_a_figure}" border="0" />
        </a>
        <br />
    {/if}

<br />
    {*
        inode_id not need I guest ...
        title [done]
        add_time_t [done]
        edit_time_t [done]
        inode_up [done]
        inode_down [done]
        edit [done]
        drop [done]
    *}

    {section name=one loop=$java_identifications_on_a_figure}

    <table border="0">
    <tr><td valign="top">
        <a href="javascript:popup('{$java_identifications_on_a_figure[one].try_a_java_identifications_on_a_figure}', 790, 590)" >{$java_identifications_on_a_figure[one].title}</a>


        {if isset ($java_identifications_on_a_figure[one].edit)}
            <a href="{$java_identifications_on_a_figure[one].edit}" >
                <img  border="0" title="{$_LANG.edit}" src="templates/inicrond_default/images/b_edit.png" />
            </a>
        {/if}

        {if isset ($java_identifications_on_a_figure[one].drop)}
            <a href="{$java_identifications_on_a_figure[one].drop}" >
                <img  border="0" title="{$_LANG.remove}" src="templates/inicrond_default/images/b_drop.png" />
            </a>
        {/if}

        {if isset ($java_identifications_on_a_figure[one].inode_up)}
            <a href="{$java_identifications_on_a_figure[one].inode_up}" >
                <img  border="0" title="{$_LANG.inode_up}" src="templates/inicrond_default/images/inode_up.png" />
            </a>
        {/if}

        {if isset ($java_identifications_on_a_figure[one].inode_down)}
            <a href="{$java_identifications_on_a_figure[one].inode_down}" >
                <img  border="0" title="{$_LANG.inode_down}" src="templates/inicrond_default/images/inode_down.png" />
            </a>

            <a href="inode_groups.php?&inode_id={$java_identifications_on_a_figure[one].inode_id}" >
                <img  border="0" title="{$_LANG.authorized_groups}" src="templates/inicrond_default/images/group.gif" />
            </a>

            <a href="inode_location.php?&inode_id={$java_identifications_on_a_figure[one].inode_id}">
                <img  border="0"  title="{$_LANG.inode_location}" src="templates/inicrond_default/images/inode_location.gif" />
            </a>


        {/if}

        {if isset ($java_identifications_on_a_figure[one].list_java_identifications_on_a_figure_result)}
            <a href="{$java_identifications_on_a_figure[one].list_java_identifications_on_a_figure_result}" >
                <img  border="0" title="{$_LANG.list_java_identifications_on_a_figure_result}" src="templates/inicrond_default/images/download_acts.png" />
            </a>
        {/if}

        {if isset ($java_identifications_on_a_figure[one].activities_report_for_a_java_identifications_on_a_figure)}
            <a href="{$java_identifications_on_a_figure[one].activities_report_for_a_java_identifications_on_a_figure}" >
                <img  border="0" title="{$_LANG.activities_report_for_a_java_identifications_on_a_figure}" src="templates/inicrond_default/images/dl_report.png" />
            </a>
        {/if}

        {if isset ($java_identifications_on_a_figure[one].list_java_identifications_on_a_figure_result_with_user_id)}
            <a href="{$java_identifications_on_a_figure[one].list_java_identifications_on_a_figure_result_with_user_id}">{$_LANG.my_results}</a>
        {/if}


        <br />

        {$java_identifications_on_a_figure[one].image_file_name}<br  />
        {$_LANG.add_gmt} : {$java_identifications_on_a_figure[one].add_time_t} <br  />
        {$_LANG.edit_gmt} : {$java_identifications_on_a_figure[one].edit_time_t} <br /><br  />
        <a href="{$java_identifications_on_a_figure[one].get_xml_informations_for_a_java_identifications_on_a_figure}">{$_LANG.get_xml_informations_for_a_java_identifications_on_a_figure}</a><br />
        </td>

        <td valign="top">

        <img src="{$java_identifications_on_a_figure[one].get_java_identifications_on_a_figure_image}" width="200" />
        </td>
        </tr>
        </table>
    {/section}

{/if}

