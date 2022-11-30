<?php

namespace App\Service\Translation\Method;

use App\App;
use App\Service\Translation\Request;
use App\Service\Translation\Response;
use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

class MysqlBasicTranslator implements BasicTranslatorInterface
{
    public const SOURCE_ID = 'mysql';

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
                    return new Response($request);
                }
            }
        );
    }
}
