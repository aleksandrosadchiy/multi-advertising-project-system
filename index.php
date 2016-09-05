<?php

ini_set("display_errors", "On");
error_reporting(E_ALL);

define("PROJECT_DIR", __DIR__ . DIRECTORY_SEPARATOR); //what is this????

require_once "src/Bootstrap.php";

date_default_timezone_set('UTC'); //move to config

$bootsrap = new \Deployer\Bootstrap();
#$bootsrap->start();
$di = $bootsrap->getDiContainer();
$cr = $di->get('credentialRepository');
