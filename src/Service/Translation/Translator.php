<?php

namespace App\Service\Translation;

use App\Service\Translation\Method\TranslationMethodInterface;
use React\Promise\PromiseInterface;

class Translator
{
    /**
     * @var TranslationMethodInterface
     */
    private TranslationMethodInterface $methodRoot;

    /**
     * @param TranslationMethodInterface $firstMethod
     */
    public function __construct(TranslationMethodInterface $firstMethod)
    {
        $this->methodRoot = $firstMethod;
    }

    /**
     * @param Request $request
     * @return PromiseInterface
     */
    public function translate(Request $request): PromiseInterface
    {
        /** @var TranslationMethodInterface $method */
        return $this->methodRoot->translate($request);
    }
}
