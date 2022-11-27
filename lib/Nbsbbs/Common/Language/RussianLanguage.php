<?php

namespace Nbsbbs\Common\Language;

class RussianLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'ru';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Русский';
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
