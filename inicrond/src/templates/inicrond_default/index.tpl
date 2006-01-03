{* Smarty *}
{* $Id$ *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>{$module_title|strip_tags}</title>

<link type="text/css" rel="stylesheet" href="../../templates/inicrond_default/css/styles.css" />

{if isset($extra_css)}
    {$extra_css}
{/if}

{if isset($extra_js)}
    {$extra_js}
{/if}

</head>
<body {if isset($HTMLArea_init)}{$HTMLArea_init} {/if}>

        {$header}
        <table>
        <tr>
        <td>
        <h3>{$title}</h3>
        </td>

        <td>

{if isset($courses)}
    {$courses}
    {$usr_cp}
    {$log_out}
    {$edit_user}
    {$my_groups}
    {$change_password}
{else}
    {$connect}
    {$register}
    {$forgot_password}

{/if}

{if isset($admin_menu)}
    {$admin_menu}
{/if}

{if isset($print_link)}
    {$print_link}
{/if}


</td></tr></table>
<h3>{$module_title}</h3>
 <table width="100%" border="0" cellPadding="5" cellSpacing="0">

                <tr>
                        <td class="window_content">
                                {$module_content}
                        </td>
                </tr>
</table>



    {$footer}



<p align="right">

{$app_link}

</p>
{if isset($debug_mod_content)}
{$debug_mod_content}
{/if}

</body>
</html>