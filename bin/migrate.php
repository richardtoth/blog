#!/usr/bin/env php
<?php

use Refaktor\Blog\DeliveryMechanism\CLI\DatabaseMigrationApplication;
use Refaktor\Blog\DependencyInjection\AurynDependencyInjectionContainer;

require_once(__DIR__ . '/../vendor/autoload.php');

$config = require(__DIR__ . '/../config/config.php');
$app = new DatabaseMigrationApplication(new AurynDependencyInjectionContainer(), $config);
$app->execute();
