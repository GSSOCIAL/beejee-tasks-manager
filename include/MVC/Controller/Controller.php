<?php
class Controller{
    public $module = null;
    public $action = "index";
    public $record = null;
    public $bean = null;
    public $view = "index";
    public $viewFactory = null;

    /**
     * Первичная настройка контроллера
     */
    public function setup($module=null){
        $this->module = $module;
        $this->viewFactory = View::getView($this->view,$this->module);
        return $this;
    }

    /**
     * Запускает действия
     */
    public function execute(){
        $this->viewFactory->display();
        return $this;
    }

    /**
     * Получает экземпляр контроллера модуля
     * @param String $module Название запрашиваемого модуля
     * @return Controller
     */
    static function getController($module){
        $ControllerName =  ucfirst($module) . "Controller";
        $controller = new Controller();

        if(file_exists("modules/{$module}/controller.php")){
            require_once "modules/{$module}/controller.php";
            if(class_exists($ControllerName)){
                $controller = new $ControllerName($module);
            }
        }

        $controller->setup($module);
        return $controller;
    }
}