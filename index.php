<?php
include "include/entryPoint.php";
$GLOBALS["APP"] = $app = new Application();
$app->exec();