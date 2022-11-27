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

class RedisTranslationMethod implements TranslationMethodInterface
{
    public const SOURCE_ID = 'redis';

    private Client $redis;

    private ?TranslationMethodInterface $next = null;

    /**
     * @param Client $redis
     */
    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param TranslationMethodInterface $next
     * @return $this
     */
    public function withNext(TranslationMethodInterface $next): self
    {
        $this->next = $next;
        return $this;
    }

    /**
     * @param Request $request
     * @return PromiseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function translate(Request $request): PromiseInterface
    {
        return $this->redis->HGET($this->key($request->getLanguage(), $request->getQuery()), md5($request->getQuery()))->then(
            function ($value) use ($request) {
                if (!empty($value)) {
                    return (new Response($request, $value))->withSource(self::SOURCE_ID);
                } else {
                    if (is_null($this->next)) {
                        return new Response($request);
                    } else {
                        return $this->next->translate($request);
                    }
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
