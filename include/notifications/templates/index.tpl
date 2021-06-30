<div class="notifications-container">
{foreach from=$notifications item=notification}
    {if $notification.type == 'info'}
        {include file="include/notifications/templates/info.tpl" body=$notification.message}
    {elseif $notification.type == 'success'}
        {include file="include/notifications/templates/success.tpl" body=$notification.message}
    {elseif $notification.type == 'warn'}
        {include file="include/notifications/templates/warn.tpl" body=$notification.message}
    {elseif $notification.type == 'note'}
        {include file="include/notifications/templates/note.tpl" body=$notification.message}
    {elseif $notification.type == 'error'}
        {include file="include/notifications/templates/error.tpl" body=$notification.message}
    {/if}
{/foreach}
</div>