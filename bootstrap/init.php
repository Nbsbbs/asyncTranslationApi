<?php
ini_set('display_errors', true);
require_once __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotEnv = Dotenv::createImmutable(__DIR__.'/../');
$dotEnv->load();

require_once __DIR__.'/container.php';
require_once __DIR__.'/routes.php';
