<?php

require_once "include/MVC/Controller/Controller.php";
require_once "include/MVC/View/View.php";

class Application{
    public $controller = null;
    protected $default_module = "Home";

    function exec(){
        $module = $this->default_module;
        $this->controller = Controller::getController($module);
        $this->controller->execute();
    }
}