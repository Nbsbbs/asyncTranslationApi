<?php

namespace Nbsbbs\Common\Language;

class DanishLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'da';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Dansk';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'da';
    }

    /**
     * @inheritDoc
     */
    public function isRightToLeft(): bool
    {
        return false;
    }
}
