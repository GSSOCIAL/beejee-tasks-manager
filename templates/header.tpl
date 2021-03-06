<div class="application-header">
    <div class="application-logo"></div>
    <div class="application-navigation">
        <ul class="navigation">
            <li class="selected">
                <a href="index.php?module=Tasks&action=index">{$APP.NAV_TASKS}</a>
            </li>
            <li class="button">
                <a href="index.php?module=Tasks&action=edit">{$APP.CREATE_TASK}</a>
            </li>
        </ul>
    </div>
    <div class="application-header-actions">
        {if !$is_authentificated}
        <a href="index.php?module=Users&action=login" class="button primary">Войти</a>
        {else}
            {if $is_admin}
            <a href="index.php?module=Administration&action=index" class="button primary">Администрирование</a>
            {/if}
            <a href="index.php?module=Users&action=logout" class="button danger">Выйти</a>
        {/if}
    </div>
</div>