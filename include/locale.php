<?php
global $application_config;

$mod_strings = array();
$app_strings = array();
if(is_array($application_config) && array_key_exists("locale",$application_config)){
    /**
     * TODO - Кэширование (занести в кэш и читать)
     */
    if(is_dir("locale/{$application_config['locale']}")){
        foreach(scandir("locale/{$application_config['locale']}") as $file){
            $filename = "locale/{$application_config['locale']}/{$file}";
            if(in_array($file,array(".",".."))) continue;
            if(!is_file($filename)) continue;
            
            require_once $filename;
        }
    }
}