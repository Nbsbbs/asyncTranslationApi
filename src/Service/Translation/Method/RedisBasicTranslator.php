<?php

namespace App\Service\Translation\Method;

use App\App;
use App\Service\Translation\Request;
use App\Service\Translation\Response;
use Clue\React\Redis\Client;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use React\Promise\PromiseInterface;

class RedisBasicTranslator implements BasicTranslatorInterface
{
    public const SOURCE_ID = 'redis';

    private Client $redis;

    /**
     * @param Client $redis
     */
    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param Request $request
     * @return PromiseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function translate(Request $request): PromiseInterface
    {
        App::logger()->debug('Request ' . $request->getLanguage() . ':' . $request->getQuery() . ', method ' . __CLASS__);
        return $this->redis->HGET($this->key($request->getLanguage(), $request->getQuery()), md5($request->getQuery()))->then(
            function ($value) use ($request) {
                App::logger()->debug('Got value ' . $value . ' in ' . __CLASS__);
                if (!empty($value)) {
                    App::logger()->debug('Returning ok ' . ($value) . ' in ' . __CLASS__);
                    return (new Response($request, $value))->withSource(self::SOURCE_ID);
                } else {
                    return new Response($request);
                }
            },
            function ($error) {
                App::get(LoggerInterface::class)->error($error->getMessage());
            }
        );
    }

    /**
     * @param string $langCode
     * @param string $query
     * @return string
     */
    protected function key(string $langCode, string $query): string
    {
        return "translate:cache:" . $langCode;
    }
}
