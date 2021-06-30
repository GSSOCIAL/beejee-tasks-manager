<?php
class DBManager{
    public $c;

    function __construct(){
        global $application_config,$app_strings;
        if(array_key_exists("db",$application_config) && is_array($application_config["db"])){
            $host = array_key_exists("host",$application_config["db"])?$application_config["db"]["host"]:null;
            $user = array_key_exists("user",$application_config["db"])?$application_config["db"]["user"]:null;
            $password = array_key_exists("password",$application_config["db"])?$application_config["db"]["password"]:null;
            $name = array_key_exists("name",$application_config["db"])?$application_config["db"]["name"]:null;
            
            if(!empty($host) && !empty($user) && !empty($password) && !empty($name)){
                $this->c = new mysqli($host,$user,$password,$name);
                if($this->c->connect_error){
                    die($this->c->connect_error);
                }
                return $this;
            }
        }
        die($app_strings["DB_CONFIG_NOT_VALID"]);
    }

    function update(){

    }
    function insert($table,$cells){
        var_dump($cells);
        $table = html_entity_decode(addslashes($table));
        
        $columns = array();
        $values = array();

        foreach($cells as $column=>$value){
            $columns[] = $column;
            if(empty($value)) $value = 'NULL';
            $values[] = "'{$value}'";
        }

        $columns = implode("`,`",$columns);
        $values = implode(",",$values);

        $query = "INSERT INTO `{$table}` (`$columns`) VALUES ($values)";
        var_dump($query);
        die();
    }
    function query($query){

    }
}