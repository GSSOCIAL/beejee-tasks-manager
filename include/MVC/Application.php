<?php

require_once "include/MVC/Controller/Controller.php";
require_once "include/MVC/View/View.php";
require_once "include/MVC/Model/Model.php";

class Application{
    public $controller = null;
    protected $default_module = "Tasks";

    function exec(){
        require_once "include/modules.php";

        $module = $this->default_module;
        $template = new TemplateHandler();
        $template->display();
        $this->controller = Controller::getController($module);
        $this->controller->execute();
    }
}