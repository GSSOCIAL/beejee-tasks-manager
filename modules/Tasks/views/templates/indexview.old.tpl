<h1>{$APP.LBL_TASKS_LIST}</h1>
<div class="filters-row">
    <form method="GET">
        <input type="hidden" name="module" value="{$module}" />
        <input type="hidden" name="action" value="index" />
        <input type="hidden" name="page" value="{$page}" />
        <div class="input-wrapper">
            <button type="submit" name="order_by" value="id" class="button {if $order_by != 'id'} default{/if}">Сначала новые</button>
            <button type="submit" name="order_by" value="name" class="button {if $order_by != 'name'} default{/if}">По автору</button>
            <button type="submit" name="order_by" value="email" class="button {if $order_by != 'email'} default{/if}">По E-mail</button>
            <button type="submit" name="order_by" value="status" class="button {if $order_by != 'status'} default{/if}">По статусу</button>
        </div>
    </form>
</div>
<div class="tasks-list">
    {foreach from=$list item="bean"}
        <div class="task-item">
            <div class="status {$bean.status}">
                {$APP.tasks_status[$bean.status]}
            </div>
            <div class="author">
                <div class="name">{$bean.name}</div>
                <div class="author-address">{$bean.email}</div>
            </div>
            <div class="task-content">
                <p>{$bean.description}</p>
                <div class="task-actions">
                    <a href="index.php?module=Tasks&action=detail&id={$bean.id}" class="button primary">Открыть</a>
                </div>
            </div>
        </div>
    {/foreach}
</div>
{if $pages > 1}
<div class="pagination">
    <form method="GET">
    <input type="hidden" name="module" value="{$module}" />
    <input type="hidden" name="action" value="index" />
    <input type="hidden" name="order_by" value="{$order_by}" />
    {counter start=1 name="r_page" assign="r_page" print=false}
    {while $r_page <= $pages}
        <input type="submit" name="page" value="{$r_page}" class="button {if $r_page != $page} default{/if}"/>
        {counter name="r_page" print=false}
    {/while}
    </form>
</div>
{/if}