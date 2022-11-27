<?php

use App\App;
use App\Service\Translation\Method\LastResortTranslationMethod;
use App\Service\Translation\Method\MysqlTranslationMethod;
use App\Service\Translation\Method\RedisTranslationMethod;
use Clue\React\Redis\Client as RedisClient;
use DI\ContainerBuilder;
use EspressoByte\LoopUtil\FileLogger\Monolog\FileHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use React\EventLoop\Loop;
use React\MySQL\ConnectionInterface;
use React\MySQL\Factory;

$builder = new ContainerBuilder();
$builder->enableCompilation($_ENV['TMP_DIR']);
$builder->useAutowiring(true);
$builder->useAnnotations(false);
$builder->addDefinitions([
    ConnectionInterface::class => function (ContainerInterface $c) {
        $factory = new Factory();
        return $factory->createLazyConnection($_ENV['DB_USER'] . ':' . rawurlencode($_ENV['DB_PASS']) . '@' . $_ENV['DB_HOST'] . '/' . $_ENV['DB_DATABASE']);
    },
    RedisClient::class => function (ContainerInterface $c) {
        $factory = new \Clue\React\Redis\Factory();
        $url = 'redis+unix://' . $_ENV['REDIS_HOST'] . '?db=' . $_ENV['REDIS_DB'];
        return $factory->createLazyClient($url);
    },
    MysqlTranslationMethod::class => function (ContainerInterface $c) {
        return (new MysqlTranslationMethod($c->get(ConnectionInterface::class)))->withNext($c->get(LastResortTranslationMethod::class));
    },
    RedisTranslationMethod::class => function (ContainerInterface $c) {
        return (new RedisTranslationMethod($c->get(RedisClient::class)))->withNext($c->get(MysqlTranslationMethod::class));
    },
    LoggerInterface::class => function (ContainerInterface $c) {
        $logger = new Logger('translate');
        $logger->pushHandler(new FileHandler(Loop::get(), $_ENV['LOG_DIR'] . '/system.log'));
        return $logger;
    },
]);

$container = $builder->build();

App::$container = $container;
