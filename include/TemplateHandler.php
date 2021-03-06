<?php
class TemplateHandler{    
    public $s = null;

    function setup(){
        global $current_user;
        if(!class_exists("Smarty")){
            die("Smarty not initialized. Please, run composer update");
        }
        $this->s = new Smarty();
        $this->s->template_dir = "/";
        $this->s->compile_dir = "cache/templates";

        //Настраиваем переменные
        global $mod_strings,$app_strings;
        $this->s->assign("MOD",$mod_strings);
        $this->s->assign("APP",$app_strings);
        $this->s->assign("is_authentificated",!empty($current_user->id));
        $this->s->assign("is_admin",$current_user->is_admin);
    }

    function display(){
        $this->setup();
        $this->s->display("templates/index.tpl");
        return true;
    }

    function display_footer(){
        if(!empty($this->s) && class_exists("Smarty") && $this->s instanceof Smarty){
            $this->s->display("templates/footer.tpl");
        }
        return false;
    }
}