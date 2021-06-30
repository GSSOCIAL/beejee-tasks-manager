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
        if(method_exists($this,$actionName)){
            $this->{$actionName}();
            return $this;
        }

        //Проверяем среди списка доступных видов
        if(array_key_exists($this->action,$this->views_map)){
            $this->view = $this->views_map[$this->action];
            $this->viewFactory = View::getView($this->view,$this->module,$this->focus);
            return $this;
        }

        echo($GLOBALS["app_strings"]["LBL_CONTROLLER_ACTION_NOT_FOUND"]);
        return $this;
    }

    public function display(){
        global $notifications;
        $notifications->process();

        if($this->viewFactory && $this->viewFactory instanceof View){
            $this->viewFactory->display();
        }
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

    public function action_save(){
        global $notifications,$db;
        $update = true;
        if(empty($this->focus->id)){
            $update = false;
        }

        $view = View::getView("edit",$this->module,$this->focus);
        $view->get_metadata();

        //Соберем изменения
        if($view->metadata && array_key_exists("panels",$view->metadata)){
            $fields = array();
            $data = array();
            $errors = array();

            foreach($view->metadata["panels"] as $rows){
                $fields = array_merge($fields,$rows);
            }

            //Валидация и обработка полей
            foreach($fields as $fieldname){
                $defs = $this->focus->defs[$fieldname];
                if(is_array($defs)){
                    $field = Field::getField($defs["type"],$defs);
                    if($field){
                        $value = $field->validate();
                        if($field->validated){
                            $data[$field->name]=$field->value;
                        }else{
                            $errors[]=$field->validation_error;
                        }
                    }
                }
            }

            //Есть ошибки
            if(!empty($errors)){
                foreach($errors as $error){
                    $notifications->add("error",$error);
                }
                Application::redirect($this->module,"edit",$this->focus->id);
            }elseif(!empty($data)){
                if($update){
                    $this->update_bean($data);
                }else{
                    $this->insert_bean($data);
                }
            }
        }

        $action = "detail";
        if(array_key_exists("return_action",$_REQUEST)){
            $action = $_REQUEST["return_action"];
        }
        Application::redirect($this->module,$action,$this->focus->id);
    }

    function update_bean($data){

    }

    /**
     * Дополнительный обработчик запросов для записей - конвертация полей в бд значения
     */
    function insert_bean($data){
        global $db;
        $post=array();
        
        foreach($data as $field=>$value){
            $post[$field]=$value;
        }

        $result = $db->insert($this->focus->table,$post);
        return $result;
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