<?php

namespace Nbsbbs\Common\Language;

class NederlandsLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'nl';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Nederlands';
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
