<?php

namespace App\Service\Translation;

use App\App;
use App\Service\Translation\Method\BasicTranslatorInterface;
use App\Service\Translation\Storage\StorageInterface;
use InvalidArgumentException;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

class ChainTranslator
{
    /**
     * @var array
     */
    private array $translatorMethods = [];

    /**
     * @var StorageInterface
     */
    private StorageInterface $storage;

    /**
     * @param array $translatorMethods
     * @param StorageInterface $storage
     */
    public function __construct(array $translatorMethods, StorageInterface $storage)
    {
        foreach ($translatorMethods as $method) {
            if ($method instanceof BasicTranslatorInterface) {
                $this->translatorMethods[] = $method;
            } else {
                throw new InvalidArgumentException('All methods must implement ' . BasicTranslatorInterface::class);
            }
        }
        $this->storage = $storage;
    }

    /**
     * @param Request $request
     * @return PromiseInterface
     */
    public function translate(Request $request): PromiseInterface
    {
        $current = $this->promise($request);
        foreach ($this->translatorMethods as $method) {
            /**
             * @var BasicTranslatorInterface $method
             */
            $current = $current->then(
                function (Response $response) use ($method) {
                    App::logger()->debug('Got response: ' . ($response->isOk() ? 'ok' : 'no') . ' from ' . $response->getSource());
                    if (!$response->isOk()) {
                        App::logger()->debug('Chaining translation to method ' . get_class($method) . ' because ' . $response->isOk() . ', ' . $response->getTranslated());
                        return $method->translate($response->getRequest());
                    } else {
                        App::logger()->debug('Found translation in ' . $response->getSource() . ' current ' . get_class($method));
                        return $response;
                    }
                }
            );
        }

        return $current->then(function (Response $response) {
            return $this->postProcessing($response);
        });
    }

    /**
     * @param Response $response
     * @return PromiseInterface
     */
    protected function postProcessing(Response $response): PromiseInterface
    {
        return $this->storeResponse($response);
    }

    /**
     * @param Response $response
     * @return void
     */
    protected function storeResponse(Response $response): PromiseInterface
    {
        return $this->storage->store($response);
    }

    /**
     * @param Request $request
     * @return PromiseInterface
     */
    protected function promise(Request $request): PromiseInterface
    {
        $deferred = new Deferred();
        $deferred->resolve((new Response($request))->withSource('root'));
        return $deferred->promise();
    }
}
