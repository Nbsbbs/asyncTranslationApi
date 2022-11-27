<?php

namespace App\Service\Translation\Method;

use App\Service\Translation\Request;
use App\Service\Translation\Response;
use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

class MysqlTranslationMethod implements TranslationMethodInterface
{
    public const SOURCE_ID = 'mysql';

    private ConnectionInterface $connection;

    private ?TranslationMethodInterface $next = null;

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param TranslationMethodInterface $next
     * @return TranslationMethodInterface
     */
    public function withNext(TranslationMethodInterface $next): TranslationMethodInterface
    {
        $this->next = $next;
        return $this;
    }

    /**
     * @param Request $request
     * @return PromiseInterface
     */
    public function translate(Request $request): PromiseInterface
    {
        $data = [
            $request->hash(),
            $request->getLanguage(),
            $request->getTargetLanguage(),
            $request->getQuery(),
        ];

        return $this->connection->query('SELECT * FROM translation_cache where md5_hash=? and lang_from=? and lang_to=? and text_from=?', $data)->then(
            function (QueryResult $result) use ($request) {
                if ($result->resultRows) {
                    $row = array_shift($result->resultRows);
                    $response = new Response($request, $row['text_to']);
                    $response->withSource(self::SOURCE_ID);
                    return $response;
                } else {
                    if (is_null($this->next)) {
                        return new Response($request);
                    } else {
                        return $this->next->translate($request);
                    }
                }
            }
        );
    }
}
