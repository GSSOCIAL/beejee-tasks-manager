<?php
require_once "include/Fields/Email/Email.php";
require_once "include/Fields/Text/Text.php";

class Field{
    public $name = "";
    public $type = "varchar";
    public $label = "";
    public $required = false;
    public $length = 200;
    public $view = "detail";

    public function display(){
        $this->s = new Smarty();
        $this->s->template_dir = "/";
        $this->s->compile_dir = "cache/templates";
        $this->s->plugins_dir[] = "include/smarty/functions";

        if(!is_dir("cache/templates")){
            mkdir("cache/templates");
        }

        $template = null;
        if(file_exists("include/Fields/".ucfirst($this->type)."/".strtolower($this->view).".tpl")){
            $template = "include/Fields/".ucfirst($this->type)."/".strtolower($this->view).".tpl";
        }
        $this->s->display($template);
    }

    public function setup($defs){
        if(is_array($defs)){
            if(array_key_exists("name",$defs)) $this->name = $defs['name'];
            if(array_key_exists("required",$defs)) $this->required = $defs['required']==true;
            if(array_key_exists("length",$defs)) $this->length = intval($defs['length']);
            if(array_key_exists("label",$defs)) $this->label = trim($defs['label']);
        }
        return $this;
    }

    static function getField($type="varchar",$defs=array()){
        $class = "Field".ucfirst($type);
        $field = new Field();

        if(class_exists($class)){
            $field = new $class();
        }

        $field->setup($defs);
        return $field;
    }
}