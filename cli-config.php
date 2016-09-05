<?php
require 'vendor/autoload.php';
define("PROJECT_DIR", __DIR__ . "/");
/** @var  $manager */
$manager = new Deployer\Cvs\GIT\Api\Bitbucket\CredentialRepository();

$connect = $manager->createEntityManager();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($connect);