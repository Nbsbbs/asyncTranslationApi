<?php

require_once "bootstrap/init.php";

use App\App;
use Psr\Log\LoggerInterface;
use React\Http\HttpServer;
use React\Socket\SocketServer;

$server = new HttpServer(App::router());
$socket = new SocketServer('213.152.172.178:8001');

App::get(LoggerInterface::class)->warning('Started');

echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;
$server->listen($socket);
