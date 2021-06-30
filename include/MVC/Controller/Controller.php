<?php
class Controller{
    public $module = null;
    public $action = "index";
    public $record = null;
    public $focus = null;
    public $view = "index";
    public $viewFactory = null;
    public $views_map = array();

    /**
     * Первичная настройка контроллера
     */
    public function setup($module=null){
        $this->module = $module;
        if(array_key_exists("module",$_REQUEST)){
            $this->module = $_REQUEST["module"];
        }
        if(array_key_exists("action",$_REQUEST)){
            $this->action = $_REQUEST["action"];
        }
        if(array_key_exists("id",$_REQUEST)){
            $this->record = $_REQUEST["id"];
        }
        $this->views_map = $this->getViewsMap();
        $focus = Model::getModel($this->module);
        if($focus instanceof Model){
            if(!empty($this->record)){
                $focus->retrieve($this->record);
            }
            $this->focus = $focus;
        }
        return $this;
    }

    /**
     * Запускает действия
     */
    public function execute(){
        //Проверяем, есть ли такой экшн
        $actionName = "action_{$this->action}";
        if(property_exists($this,$actionName) && is_callable($this->{$actionName})){
            $this->{$actionName}();
            return $this;
        }

        //Проверяем среди списка доступных видов
        if(array_key_exists($this->action,$this->views_map)){
            $this->view = $this->views_map[$this->action];
            $this->viewFactory = View::getView($this->view,$this->module,$this->focus);
            $this->viewFactory->display();
            return $this;
        }

        echo($GLOBALS["app_strings"]["LBL_CONTROLLER_ACTION_NOT_FOUND"]);
        return $this;
    }

    /**
     * Список доступных вьюх
     * @return Array
     */
    public function getViewsMap(){
        require_once "include/MVC/Controller/viewsmap.php";
        if(file_exists("modules/{$this->module}/viewsmap.php")){
            require_once "modules/{$this->module}/viewsmap.php";
        }
        return $viewsmap;
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