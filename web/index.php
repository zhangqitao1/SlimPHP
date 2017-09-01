<?php

/** @var SlimPHP $app */
use Slim\SlimPHP;

$app = require_once __DIR__ . '/../bootstrap.php';

//require __DIR__ . '/../src/controllers.php';
$app->run();
