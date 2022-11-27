<?php

namespace Nbsbbs\Common\Language;

class KoreanLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'ko';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return '한국어';
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
