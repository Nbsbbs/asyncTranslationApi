<?php

namespace Nbsbbs\Common\Language;

class ItalianLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'it';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Italiano';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->getCode();
    }

    /**
     * @inheritDoc
     */
    public function isRightToLeft(): bool
    {
        return false;
    }
}
