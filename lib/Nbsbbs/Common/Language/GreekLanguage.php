<?php

namespace Nbsbbs\Common\Language;

class GreekLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'el';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'ελληνικά';
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
