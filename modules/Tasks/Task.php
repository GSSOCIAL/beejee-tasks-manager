<?php
class Task extends Model{
    public $table = "tasks";
    public $defs = array(
        "name"=>array(
            "name"=>"name",
            "label"=>"Автор",
            "type"=>"varchar",
            "required"=>true,
            "length"=>64
        ),
        "email"=>array(
            "name"=>"email",
            "label"=>"Адрес эл. почты",
            "type"=>"email",
            "required"=>true,
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
            "required"=>true,
            "list"=>"tasks_status"
        ),
    );
}