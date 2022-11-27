<?php

namespace Nbsbbs\Common\Language;

class EnglishLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'en';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'English';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'en';
    }

    /**
     * @inheritDoc
     */
    public function isRightToLeft(): bool
    {
        return false;
    }

    /**
     * @return int
     */
    public function getWeght(): int
    {
        return 2;
    }
}
