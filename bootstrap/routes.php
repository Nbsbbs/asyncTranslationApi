<?php

use App\App;
use App\Controller\Info;
use App\Router;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;

$routes = new RouteCollector(new Std(), new GroupCountBased());
$routes->get('/info', new Info());
$routes->post('/info', new Info());

return new Router($routes);
