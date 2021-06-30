<?php
class Task extends Model{
    public $table = "tasks";
    public $defs = array(
        "name"=>array(
            "name"=>"name",
            "label"=>"Автор",
            "type"=>"varchar",
            "required"=>true,
            "length"=>64,
            "sorting"=>true
        ),
        "email"=>array(
            "name"=>"email",
            "label"=>"Адрес эл. почты",
            "type"=>"email",
            "required"=>true,
            "sorting"=>true
        ),
        "description"=>array(
            "name"=>"description",
            "label"=>"Задача",
            "type"=>"text",
            "required"=>true,
        ),
        "status"=>array(
            "name"=>"status",
            "label"=>"Статус",
            "type"=>"enum",
            "required"=>false,
            "list"=>"tasks_status",
            "sorting"=>true
        ),
        "modified"=>array(
            "name"=>"modified",
            "label"=>"Редактировано администратором",
            "type"=>"bool",
            "required"=>false,
        ),
    );
    public $modified_by = array("description");
}