<?php

namespace App;

use Psr\Container\ContainerInterface;

class App
{
    /**
     * @var ContainerInterface
     */
    public static ContainerInterface $container;

    /**
     * @var Router
     */
    public static Router $router;

    /**
     * @param string $class
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function get(string $class)
    {
        return self::$container->get($class);
    }

    /**
     * @return Router
     */
    public static function router()
    {
        return self::$router;
    }
}
