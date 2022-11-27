<?php

namespace App\Service\Translation\Method;

use App\Service\Translation\Request;
use React\Promise\PromiseInterface;

interface TranslationMethodInterface
{
    /**
     * @param Request $request
     * @return PromiseInterface
     */
    public function translate(Request $request): PromiseInterface;

    /**
     * @param TranslationMethodInterface $next
     * @return $this
     */
    public function withNext(TranslationMethodInterface $next): self;
}
