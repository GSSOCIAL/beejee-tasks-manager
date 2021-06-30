<?php

class FieldEnum extends Field{
    public $type = "enum";
    public $list = "";

    function setup($defs){
        parent::setup($defs);
        if(is_array($defs)){
            if(array_key_exists("list",$defs)) $this->list = trim($defs['list']);
        }
        return $this;
    }
    function pre_display(){
        global $app_strings;
        parent::pre_display();

        $value = $this->value;
        if(!empty($this->list)){
            if(array_key_exists($this->list,$app_strings) && array_key_exists($value,$app_strings[$this->list])){
                $value = $app_strings[$this->list][$value];
            }
        }
        $this->s->assign("list_value",$value);
    }
}