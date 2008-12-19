{* Smarty *}
{* $Id: js_redir.tpl 8 2005-09-13 17:44:21Z sebhtml $ *}
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>


<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1" />
<link type="text/css" rel="stylesheet" href="../../templates/inicrond_default/styles.css" />
	
  <title>


  </title>
</head>
<body>
<p align="center">
<table cellpadding="5" >
	<tr>
		<td align="center" class="window_title">
		{$redir_body_msg}
		<hr />
		<small>{$redir_msg}
		<a href="{$redir_url}">{$redir_here}</a></small>
		</td>
	</tr>
</table>

</p>
<SCRIPT language="JavaScript"> 
<!--
  
   
   setTimeout('window.location="{$redir_url}";',2000);
     
//--> 
</SCRIPT> 
</body>
</html>