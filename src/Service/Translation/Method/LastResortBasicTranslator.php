<?php

namespace App\Service\Translation\Method;

use App\App;
use App\Service\Translation\Request;
use App\Service\Translation\Response;
use Psr\Log\LoggerInterface;
use React\MySQL\ConnectionInterface;
use React\Promise\PromiseInterface;

class LastResortBasicTranslator implements BasicTranslatorInterface
{
    private ConnectionInterface $connection;

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Request $request
     * @return PromiseInterface
     */
    public function translate(Request $request): PromiseInterface
    {
        App::logger()->debug('Request ' . $request->getLanguage() . ':' . $request->getQuery() . ', method ' . __CLASS__);
        // just log
        return $this->connection->query('INSERT INTO need_translation (lang_code, query) VALUES (?, ?) ON DUPLICATE KEY UPDATE query_count=query_count+1',
            [$request->getLanguage(), $request->getQuery()])->then(
            function () use ($request) {
                App::get(LoggerInterface::class)->error('No translation for [' . $request->getLanguage() . ':' . $request->getQuery() . ']');
                return new Response($request);
            }
        );
    }
}
