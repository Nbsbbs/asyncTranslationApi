<?php

namespace Nbsbbs\Common\Language;

class GermanLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'de';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Deutsch';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'de';
    }

    /**
     * @inheritDoc
     */
    public function isRightToLeft(): bool
    {
        return false;
    }
}
