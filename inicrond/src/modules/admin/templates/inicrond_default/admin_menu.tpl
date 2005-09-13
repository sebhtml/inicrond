{* Smarty *}

{if $CAN_UPDATE_CONFIG_FILES != ""}
{$CAN_UPDATE_CONFIG_FILES}<br />
{/if}

{if $CAN_CHANGE_OPTS != ""}
{$CAN_CHANGE_OPTS}<br />
{/if}

{if $CAN_CHANGE_USRS_ACCESS != ""}
{$CAN_CHANGE_USRS_ACCESS}<br />
{/if}

{if $MOD_ADMIN_CAN_GIVE_NEW_PASSWORD != ""}
{$MOD_ADMIN_CAN_GIVE_NEW_PASSWORD}<br />
{/if}
{if $MD_SESS_SEE_ONLINE_PEOPLE_MODULE != ""}
{$MD_SESS_SEE_ONLINE_PEOPLE_MODULE}<br />
{/if}

{if $MOD_ADMIN_CAN_CHANGE_BLOCKS_POSITION != ""}
{$MOD_ADMIN_CAN_CHANGE_BLOCKS_POSITION}<br />
{/if}


<a href="{$list_user_in_0_group}">{$_LANG.list_user_in_0_group}</a><br />

{$lang_dev}<br />

	
{if $CAN_SEE_GRPS != ""}
{$CAN_SEE_GRPS}<br />
{/if}

{if $CAN_VIEW_USRS != ""}
{$CAN_VIEW_USRS}<br />
{/if}

{if $MD_SESS_CAN_SEE_GRAPH_WITH_HTTP_USER_AGENT != ""}
{$MD_SESS_CAN_SEE_GRAPH_WITH_HTTP_USER_AGENT}<br />
{/if}

{if $smarty_cache_config_link != ""}
<a href="{$smarty_cache_config_link}">{$_LANG.smarty_cache_config}</a><br />
{/if}
