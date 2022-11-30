<?php

namespace App;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class App
{
    public const DEFAULT_EXECUTION_TIME = 3600;

    /**
     * @var ContainerInterface
     */
    public static ContainerInterface $container;

    /**
     * @var Router
     */
    public static Router $router;

    /**
     * @var int
     */
    public static int $execTime = self::DEFAULT_EXECUTION_TIME;

    /**
     * @var int
     */
    public static int $startTime;

    /**
     * @param string $class
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function get(string $class)
    {
        return self::$container->get($class);
    }

    /**
     * @return bool
     */
    public static function isNeedStop(): bool
    {
        return (microtime(true) - self::$startTime) > self::$execTime;
    }

    /**
     * @return Router
     */
    public static function router()
    {
        return self::$router;
    }

    /**
     * @return LoggerInterface
     */
    public static function logger(): LoggerInterface
    {
        try {
            return self::$container->get(LoggerInterface::class);
        } catch (Throwable $e) {
            throw new RuntimeException('Logger initialization failed');
        }
    }
}
