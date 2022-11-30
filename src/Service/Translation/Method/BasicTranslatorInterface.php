<?php

namespace App\Service\Translation\Method;

use App\Service\Translation\Request;
use React\Promise\PromiseInterface;

interface BasicTranslatorInterface
{
    /**
     * @param Request $request
     * @return PromiseInterface
     */
    public function translate(Request $request): PromiseInterface;
}
