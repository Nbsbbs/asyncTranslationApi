<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\App;
use Dotenv\Dotenv;

$dotEnv = Dotenv::createImmutable(__DIR__ . '/../');
$dotEnv->load();

App::$container = require_once __DIR__ . '/container.php';
App::$router = require_once __DIR__ . '/routes.php';
App::$startTime = microtime(true);
