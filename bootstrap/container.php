<?php

use App\Service\Translation\ChainTranslator;
use App\Service\Translation\Method\LastResortBasicTranslator;
use App\Service\Translation\Method\MysqlBasicTranslator;
use App\Service\Translation\Method\MysqlParalinkTranslator;
use App\Service\Translation\Method\ParalinkTranslationMethod;
use App\Service\Translation\Method\RedisBasicTranslator;
use App\Service\Translation\Storage\MysqlStorage;
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
    ChainTranslator::class => function (ContainerInterface $c) {
        $methods = [];
        $methods[] = new RedisBasicTranslator($c->get(RedisClient::class));
        $methods[] = $c->get(MysqlParalinkTranslator::class);
        $methods[] = new MysqlBasicTranslator($c->get(ConnectionInterface::class));
        $methods[] = $c->get(ParalinkTranslationMethod::class);
        $methods[] = new LastResortBasicTranslator($c->get(ConnectionInterface::class));

        return new ChainTranslator($methods, $c->get(MysqlStorage::class));
    },
    LoggerInterface::class => function (ContainerInterface $c) {
        $logger = new Logger('translate');
        $logger->pushHandler(new FileHandler(Loop::get(), $_ENV['LOG_DIR'] . '/system.log'));
        return $logger;
    },
]);

$container = $builder->build();

return $container;
