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

    public $validated=false;
    public $validation_error=null;
    public $value=null;

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

        $this->s->assign("name",$this->name);
        $this->s->assign("label",$this->label);
        $this->s->assign("required",$this->required);
        $this->s->assign("value",$this->value);

        $this->s->display($template);
    }

    public function setup($defs){
        if(is_array($defs)){
            if(array_key_exists("name",$defs)) $this->name = $defs['name'];
            if(array_key_exists("required",$defs)) $this->required = $defs['required']==true;
            if(array_key_exists("length",$defs)) $this->length = intval($defs['length']);
            if(array_key_exists("label",$defs)) $this->label = trim($defs['label']);
            if(array_key_exists("value",$defs)) $this->value = trim($defs['value']);
        }
        $this->populate_value();
        return $this;
    }

    public function populate_value(){
        $value = trim($this->value);
        $this->value = $value;
    }

    /**
     * Проверяет и форматирует данные
     */
    public function validate(){
        $value=array_key_exists($this->name,$_REQUEST)?strip_tags($_REQUEST[$this->name]):null;
        if($this->required && empty($value)){
            $this->validated=false;
            $this->validation_error = "Поле {$this->label} обязательно";
            return false;
        }
        if(!empty($this->value)){
            if(!empty($this->length) && mb_strlen($value)>$this->length){
                $this->validated=false;
                $this->validation_error = "Поле {$this->label} не должно быть больше {$this->length} знаков";
                return false;
            }
        }
        $this->value = trim(htmlspecialchars_decode($value));
        $this->validated = true;
        return true;
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