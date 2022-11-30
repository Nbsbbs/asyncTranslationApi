<?php

namespace App\Service\Translation\Storage;

use App\App;
use App\Service\Translation\Response;
use DateTimeImmutable;
use React\MySQL\ConnectionInterface;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

class MysqlStorage implements StorageInterface
{
    private const TABLE = 'translated_phrases';
    private const SAVE_SOURCES = [
        'paralink',
    ];

    /**
     * @var ConnectionInterface
     */
    private ConnectionInterface $connection;

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Response $response
     * @return PromiseInterface
     */
    public function store(Response $response): PromiseInterface
    {
        if ($this->isNeedStore($response)) {
            return $this->connection->query(
                'INSERT IGNORE INTO ' . self::TABLE . ' (`lang_from`, `text_from`, `lang_to`, `text_to`, `source`, `date_time`) VALUES (?, ?, ?, ? ,?, ?)',
                [
                    $response->getRequest()->getLanguage(),
                    $response->getRequest()->getQuery(),
                    $response->getRequest()->getTargetLanguage(),
                    $response->getTranslated(),
                    $response->getSource(),
                    $this->datetime(),
                ]
            )->then(
                function () use ($response) {
                    return $response;
                },
                function ($error) use ($response) {
                    App::logger()->error($error->getMessage());
                    return $response;
                });
        } else {
            $deferred = new Deferred();
            $deferred->resolve($response);
            return $deferred->promise();
        }
    }

    /**
     * @param Response $response
     * @return bool
     */
    protected function isNeedStore(Response $response): bool
    {
        return in_array($response->getSource(), self::SAVE_SOURCES);
    }

    /**
     * @return string
     */
    protected function datetime(): string
    {
        return (new DateTimeImmutable())->format('Y-m-d H:i:s');
    }
}
