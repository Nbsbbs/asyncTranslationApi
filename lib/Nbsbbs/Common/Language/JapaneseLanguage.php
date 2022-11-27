<?php

namespace Nbsbbs\Common\Language;

class JapaneseLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'ja';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return '日本語';
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
