<div class="edit-view">
    <form method="POST">
        <input type="hidden" name="module" value="Tasks" />
        <input type="hidden" name="action" value="save" />
        <input type="hidden" name="return_module" value="Administration" />
        <input type="hidden" name="return_action" value="index" />
        <input type="hidden" name="id" value="{$focus->id}" />
        <input type="hidden" name="gate" value="true" />

        <div class="edit-view-header">
            <h1>Редактировать задачу</h1>
        </div>
        <div class="edit-view-rows">
            <div class="edit-view-row">
                <div class="edit-view-field-wrapper">
                    <div class="edit-view-label">
                        <label>Автор</label>
                    </div>
                    <div class="edit-view-field">
                        <div class="field-wrapper">
                            <input type="text" disabled value="{$focus->name}"/>
                        </div>
                    </div>
                </div>
                <div class="edit-view-field-wrapper">
                    <div class="edit-view-label">
                        <label>E-mail</label>
                    </div>
                    <div class="edit-view-field">
                        <div class="field-wrapper">
                            <input type="text" disabled value="{$focus->email}"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="edit-view-row">
                <div class="edit-view-field-wrapper">
                    <div class="edit-view-label">
                        <label>Задача</label>
                    </div>
                    <div class="edit-view-field">
                        <div class="field-wrapper">
                            <textarea name="description">{$focus->description}</textarea>
                        </div>
                    </div>
                </div>
                <div class="edit-view-field-wrapper">
                    <div class="edit-view-label">
                        <label>Статус</label>
                    </div>
                    <div class="edit-view-field">
                        <div class="field-wrapper">
                            <select name="status">
                                <option value=" ">Не задан</option>
                                <option value="fault" {if $focus->status =='fault'}selected{/if}>Не выполнена</option>
                                <option value="success" {if $focus->status =='success'}selected{/if}>Завершена</option>
                                <option value="timeout" {if $focus->status =='timeout'}selected{/if}>Просрочена</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="edit-view-field-wrapper">
                    <div class="edit-view-label">
                        <label>Отредактирована администратором</label>
                    </div>
                    <div class="edit-view-field">
                        <div class="field-wrapper">
                            {if $focus->modified}
                                <input type="checkbox" disabled checked />
                            {else}
                                <input type="checkbox" disabled/>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="edit-view-actions">
            <input type="submit" name="submit" class="primary" value="Обновить" />
            
        </div>
    </form>
</div>