<div class="edit-view">
    <form method="POST">
        <input type="hidden" name="module" value="" />
        <input type="hidden" name="action" value="edit" />
        <input type="hidden" name="return_action" value="detail" />
        <input type="hidden" name="id" value="" />
        <div class="edit-view-rows">
            {foreach from=$panels item="rows"}
                <div class="edit-view-row">
                {foreach from=$rows item="field"}
                    <div class="edit-view-field-wrapper">
                        <div class="edit-view-label">
                            <label>{$field.label}</label>
                        </div>
                        <div class="edit-view-field">
                            <div class="field-wrapper">
                                {field defs=$field.defs view="edit"}
                            </div>
                        </div>
                    </div>
                {/foreach}
                </div>
            {/foreach}
        </div>
    </form>
</div>