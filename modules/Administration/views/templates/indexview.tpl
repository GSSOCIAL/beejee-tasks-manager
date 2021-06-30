<h1>Управление задачами</h1>
<div class="tasks-admin-view">
    <table class="list-view">
        <thead>
            <tr>
                <th width="15%">Автор</th>
                <th width="10%">Статус</th>
                <th>Задача</th>
                <th width="1"></th>
            </tr>
        </thead>
        <tbody>
        {foreach from=$list item="task"}
            <tr>
                <td>{$task.name}</td>
                <td>{$task.status}</td>
                <td>{$task.description}</td>
                <td>
                    <a href="index.php?module=Administration&action=editTask&id={$task.id}" class="button">Редактировать</a>
                </td>
            </tr>
        {/foreach}
    </tr>
    </table>
</div>