<?php
class Model{
    public $id = null;
    public $deleted = false;
    
    function retrieve($id=1){

    }

    static function getModel($module){
        global $beanList,$moduleList;
        if(is_array($beanList) && array_key_exists($module,$beanList)){
            $name = $beanList[$module];
            if(class_exists($name)){
                return new $name();
            }
        }
        return null;
    }
}