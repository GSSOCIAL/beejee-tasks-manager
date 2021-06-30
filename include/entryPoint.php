<?php
set_include_path(
    dirname(__FILE__).'/..'.PATH_SEPARATOR.
    get_include_path()
);

$BASE_DIR = realpath(dirname(__DIR__));
$autoloader = $BASE_DIR.'/vendor/autoload.php';
if(file_exists($autoloader)) {
    require_once $autoloader;
}else{
    die("Composer not found. Please install via 'composer install'");
}

if(file_exists("config.php")){
    require_once "config.php";
    $GLOBALS["config"] = isset($application_config) && is_array($application_config)?$application_config:array();
}

if(!is_dir("cache")){
    mkdir("cache");
}

require_once "include/utils.php";
require_once "include/locale.php";

require_once "include/TemplateHandler.php";
require_once "include/Fields/Field.php";

require_once "include/notifications.php";
$notifications = new Notifications();
require_once "include/db.php";
$db = new DBManager();

global $current_user;
require_once "include/MVC/Application.php";