<h1>{$APP.LBL_TASKS_LIST}</h1>
<div class="tasks-list">
    <form method="GET">
        <input type="hidden" name="module" value="{$module}" />
        <input type="hidden" name="action" value="index" />
        <input type="hidden" name="page" value="{$page}" />
        <input type="hidden" name="sort" value="{$sort}" />
        <input type="hidden" name="sorting" value="true" />
        <input type="hidden" name="old_order" value="{$order_by}" />

        <table class="list-view">
            <thead>
                <tr>
                    {foreach from=$columns item="col"}
                    {if $col}
                    <th>
                        <label>{$col.label}</label>
                        {if $col.sorting}
                        <button type="submit" name="order_by" value="{$col.name}" class="sorting{if $order_by == $col.name} active {$sort}{/if}">
                            
                        </button>
                        {/if}
                    </th>
                    {/if}
                    {/foreach}
                    <th width="1"></th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$list item="bean"}
                <tr>
                    {foreach from=$columns item="col"}
                        {if $col}
                        <td>
                            <span>{field defs=$col.defs view="list" value=$bean[$col.name]}</span>
                        </td>
                        {/if}
                    {/foreach}
                    <td>
                        <a href="index.php?module=Tasks&action=detail&id={$bean.id}" class="button primary">Открыть</a>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </form>
</div>
{if $pages > 1}
<div class="pagination">
    <form method="GET">
        <input type="hidden" name="module" value="{$module}" />
        <input type="hidden" name="action" value="index" />
        <input type="hidden" name="order_by" value="{$order_by}" />
        <input type="hidden" name="sort" value="{$sort}" />
        {counter start=1 name="r_page" assign="r_page" print=false}
        {while $r_page <= $pages}
            <input type="submit" name="page" value="{$r_page}" class="button {if $r_page != $page} default{/if}"/>
            {counter name="r_page" print=false}
        {/while}
    </form>
</div>
{/if}