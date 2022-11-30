<?php

namespace App\Service\Translation\Storage;

use App\Service\Translation\Response;
use React\Promise\PromiseInterface;

interface StorageInterface
{
    public function store(Response $response): PromiseInterface;
}
