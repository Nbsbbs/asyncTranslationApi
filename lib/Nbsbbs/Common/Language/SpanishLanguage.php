<?php

namespace Nbsbbs\Common\Language;

class SpanishLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'es';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Español';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'es';
    }

    /**
     * @inheritDoc
     */
    public function isRightToLeft(): bool
    {
        return false;
    }
}
