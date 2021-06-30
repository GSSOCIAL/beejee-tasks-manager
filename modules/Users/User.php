<?php
class User extends Model{
    public $table = "users";
    public $defs = array(
        "name"=>array(
            "name"=>"name",
            "label"=>"Имя",
            "type"=>"varchar",
            "required"=>true,
            "length"=>64
        ),
        "login"=>array(
            "name"=>"login",
            "label"=>"Логин",
            "type"=>"varchar",
            "required"=>true,
        ),
        "password"=>array(
            "name"=>"password",
            "label"=>"Пароль",
            "type"=>"password",
            "required"=>true,
        ),
        "is_admin"=>array(
            "name"=>"is_admin",
            "label"=>"Администратор",
            "type"=>"bool",
        ),
    );

    function populate(){
        global $current_user;
        if(!session_id()){
            session_start();
        }
        if(array_key_exists("user",$_SESSION)){
            $current_user = new User();
            $current_user->retrieve($_SESSION["user"]);
        }
    }
}