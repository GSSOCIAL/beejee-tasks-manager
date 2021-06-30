<?php
class View{
    public $s = null;
    public $template = null;

    public function display(){
        if(!empty($this->template) && file_exists($this->template)){
            $this->s->display($this->template);
        }else{
            die("Couldnt render page. Template not found");
        }
    }

    public function setup(){
        if(!class_exists("Smarty")){
            die("Smarty not initialized. Please, run composer update");
        }
        $this->s = new Smarty();
        $this->s->template_dir = "/";
        $this->s->compile_dir = "cache/templates";

        if(!is_dir("cache/templates")){
            mkdir("cache/templates");
        }

        return $this;
    }

    /**
     * Получает экземпляр вьюхи
     * @param String $view_name Название вьюхи
     * @param String $module Название модуля
     * @return View
     */
    static function getView($view_name="index",$module=null){
        $ControllerName =  ucfirst($view_name) . "View";
        $view = null;

        //Подключим стандартную вьюху
        if(file_exists("include/MVC/View/views/view.{$view_name}.php")){
            require_once "include/MVC/View/views/view.{$view_name}.php";
        }

        //Проверим, есть ли отдельный вид для модуля
        if(file_exists("modules/{$module}/views/view.{$view_name}.php")){
            require_once "modules/{$module}/views/view.{$view_name}.php";
            $moduleViewController = ucfirst($module).$ControllerName;
            if(class_exists($moduleViewController)){
                $view = new $moduleViewController();
            }
        }

        //Регистрируем стандартный
        if(empty($view) && class_exists($ControllerName)){
            $view = new $ControllerName();
        }

        //В крайнем случае - используем пустышку
        if(empty($view)){
            $view = new View();
        }

        $view->setup();
        return $view;
    }
}