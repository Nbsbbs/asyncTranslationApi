<?php

namespace App\Service\Translation\Method;

use App\App;
use App\Service\Translation\Request;
use App\Service\Translation\Response;
use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

class MysqlParalinkTranslator implements BasicTranslatorInterface
{
    public const SOURCE_ID = 'mysql-paralink';

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
            $request->getLanguage(),
            $request->getTargetLanguage(),
            $request->getQuery(),
        ];
        return $this->connection->query('SELECT * FROM translated_phrases where lang_from=? and lang_to=? and text_from=?', $data)->then(
            function (QueryResult $result) use ($request) {
                if ($result->resultRows) {
                    $row = array_shift($result->resultRows);
                    $response = new Response($request, $row['text_to']);
                } else {
                    $response = new Response($request);
                }
                $response->withSource(self::SOURCE_ID);
                return $response;
            }
        );
    }
}
