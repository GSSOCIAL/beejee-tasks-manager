<?php

require_once "include/MVC/Controller/Controller.php";
require_once "include/MVC/View/View.php";
require_once "include/MVC/Model/Model.php";

class Application{
    public $controller = null;
    protected $default_module = "Tasks";

    function exec(){
        global $current_user;
        require_once "include/modules.php";
        $module = $this->default_module;
        if(array_key_exists("module",$_REQUEST) && in_array($_REQUEST["module"],$moduleList)){
            $module = $_REQUEST["module"];
        }
        $current_user = new User();
        $current_user->populate();

        $template = new TemplateHandler();
        $this->controller = Controller::getController($module);
        $this->controller->execute();
        $template->display();
        $this->controller->display();
    }

    static function redirect($module=null,$action="index",$id=null){
        if(empty($module)){
            $app = new Application();
            $module = $app->default_module;
        }
        $record = !empty($id)?"&id={$id}":null;
        global $notifications;
        $notifications_url = null;
        if(!empty($notifications->notifications)){
            $notifications_url = "&notifications=".$notifications->get_url();
        }
        
        header("Location:index.php?module={$module}&action={$action}{$record}{$notifications_url}");
        die();
    }
}