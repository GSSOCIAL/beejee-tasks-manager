<?php
global $moduleList,$beanList;

$moduleList = array();
$beanList = array();

$moduleList[] = "Administration";

$moduleList[] = "Tasks";
$beanList["Tasks"] = "Task";
require_once "modules/Tasks/Task.php";