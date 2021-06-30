<?php

class FieldEmail extends Field{
    public $type = "email";
    
    public function validate(){
        parent::validate();
        if($this->validated && !empty($this->value)){
            if(!filter_var($this->value,FILTER_VALIDATE_EMAIL)){
                $this->validated=false;
                $this->validation_error = "Проверьте правильность указаного адреса почты в поле {$this->label}";
                $this->value = null;
                return false;
            }
            return true;
        }
    }
}