<?php

namespace Nbsbbs\Common\Language;

class SlovakLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'sk';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Slovenčina';
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
