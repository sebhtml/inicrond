{* Smarty *}
{* $Id$ *}
<html>
	<head>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1" />

<title>{$module_title|strip_tags}</title>
<link type="text/css" rel="stylesheet" href="../../templates/inicrond_default/css/styles.css" />
{$extra_css}
{$extra_js}
</head>
<body {$HTMLArea_init}>

	{$header}
	<table>
	<tr>
	<td>
	<h3>{$title}</h3>
	</td>
	
	<td>
	










{if $courses != ""}
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
	{if $admin_menu != ""} 
	{$admin_menu} 
	{/if}
	
	{if $print_link != ""} 
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

</body>
</html>
{if $debug_mod_content != ""}
{$debug_mod_content}
{/if}