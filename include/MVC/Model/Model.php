<?php
class Model{
    public $id = null;
    public $deleted = false;

    function retrieve($id=1){
        global $db;
        $columns=array();
        foreach($this->defs as $fieldname=>$defs){
            $columns[]="t.{$fieldname}";
        }
        //получим значения полей модели
        $SELECT = implode(",",$columns);
        $query = $db->query("SELECT {$SELECT} FROM {$this->table} t WHERE t.id='{$id}' LIMIT 1");
        $data = $query->fetch_array(MYSQLI_ASSOC);
        if(is_array($data)){
            foreach($data as $fieldname=>$value){
                $this->{$fieldname} = $value;
            }
        }
        return $this;
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