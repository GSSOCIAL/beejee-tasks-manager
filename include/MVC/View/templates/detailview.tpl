<div class="edit-view">
    <div class="edit-view-header">
    <h1>{$title}</h1>
    </div>
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
                        {field defs=$field.defs view="detail"}
                    </div>
                </div>
            </div>
        {/foreach}
        </div>
    {/foreach}
    </div>
</div>