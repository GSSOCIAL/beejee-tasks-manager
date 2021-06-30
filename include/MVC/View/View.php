<?php
class View{
    public $s = null;
    public $template = null;
    public $metadata = array();
    public $metadata_file = null;
    public $focus = null;

    public $view = "index";
    public $module = null;

    public function pre_display(){
        $this->get_metadata();
        return $this;
    }

    public function get_metadata(){
        if($this->module){
            $view = strtolower($this->view);

            if(file_exists("modules/{$this->module}/metadata/{$view}view.php")){
                require_once "modules/{$this->module}/metadata/{$view}view.php";
                if(isset($metadata) && is_array($metadata) && array_key_exists($this->module,$metadata)){
                    if(is_array($metadata[$this->module]) && array_key_exists(ucfirst($this->view),$metadata[$this->module])){
                        $this->metadata_file = "modules/{$this->module}/metadata/{$view}view.php";
                        $this->metadata = $metadata[$this->module][ucfirst($this->view)];
                    }
                }
            }
        }
    }

    public function display(){
        $this->pre_display();
        if(!empty($this->template) && file_exists($this->template)){
            $this->s->display($this->template);
        }else{
            die("Couldnt render page. Template not found");
        }
    }

    public function setup($template=null,$module="",$name="index",$focus=null){
        if(!class_exists("Smarty")){
            die("Smarty not initialized. Please, run composer update");
        }
        $this->s = new Smarty();
        $this->s->template_dir = "/";
        $this->s->compile_dir = "cache/templates";
        $this->s->addPluginsDir("include/smarty/functions");
        
        if(!is_dir("cache/templates")){
            mkdir("cache/templates");
        }

        if($template && file_exists($template)){
            $this->template = $template;
        }
        
        //Настраиваем переменные
        global $mod_strings,$app_strings;
        $this->s->assign("MOD",$mod_strings);
        $this->s->assign("APP",$app_strings);

        $this->module = $module;
        $this->view = $name;
        $this->focus = $focus;

        return $this;
    }

    public function getModel(){

    }

    /**
     * Получает экземпляр вьюхи
     * @param String $view_name Название вьюхи
     * @param String $module Название модуля
     * @return View
     */
    static function getView($view_name="index",$module=null,$focus=null){
        $view_name = strtolower($view_name);
        $ControllerName =  ucfirst($view_name) . "View";
        $view = null;
        $template = null;

        //Подключим стандартную вьюху
        if(file_exists("include/MVC/View/views/view.{$view_name}.php")){
            require_once "include/MVC/View/views/view.{$view_name}.php";
        }

        if(!empty($module)){
            //Проверим, есть ли отдельный вид для модуля
            if(file_exists("modules/{$module}/views/view.{$view_name}.php")){
                require_once "modules/{$module}/views/view.{$view_name}.php";
                $moduleViewController = ucfirst($module).$ControllerName;
                if(class_exists($moduleViewController)){
                    $view = new $moduleViewController();
                }
            }

            //Шаблон
            if(file_exists("modules/{$module}/views/templates/{$view_name}view.tpl")){
                $template = "modules/{$module}/views/templates/{$view_name}view.tpl";
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

        $view->setup($template,$module,$view_name,$focus);
        return $view;
    }
}