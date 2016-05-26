<?php

use Refaktor\Blog\DependencyInjection\AurynDependencyInjectionContainer;

require_once(__DIR__ . '/../vendor/autoload.php');

$config = require(__DIR__ . '/../config/config.php');
$app = new \Refaktor\Blog\DeliveryMechanism\Web\WebApplication(new AurynDependencyInjectionContainer(), $config);
$app->execute($_SERVER, $_GET, $_POST, $_COOKIE);
