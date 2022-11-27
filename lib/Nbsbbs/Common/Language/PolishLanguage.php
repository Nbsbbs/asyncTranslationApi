<?php

namespace Nbsbbs\Common\Language;

class PolishLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'pl';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Polski';
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
