{if $value|mb_strlen > 30}
    {$value|mb_substr:0:30}...
{else}
    {$value}
{/if}