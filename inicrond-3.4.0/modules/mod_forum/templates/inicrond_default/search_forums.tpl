{* Smarty *}


	
	
	
	
	
	
{section name=index loop=$results}

<table width="100%"><tr><td class="inode_element">
<table><tr><td>
<h3><a href="{$results[index].hyperlink}">{$results[index].forum_message_titre}</a></h3></td><td> 
 {$results[index].forum_section_name} =&gt; <a href="{$results[index].forum_hyperlink}">{$results[index].forum_discussion_name}</a></td></tr>
<tr><td colspan="2"><a href="{$results[index].usr_link}">{$results[index].usr_name}</a> {$results[index].usr_prenom} {$results[index].usr_nom} {$results[index].date}</td></tr>
<tr><td colspan="2">

{$results[index].forum_message_contenu}
<br />
{$results[index].usr_signature}
</td></tr></table>
	
	
</td></tr></table>
<br /><br />
{/section}


{$mod_forum}