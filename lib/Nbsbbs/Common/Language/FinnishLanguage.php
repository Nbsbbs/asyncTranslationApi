<?php

namespace Nbsbbs\Common\Language;

class FinnishLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'fi';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Suomi';
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
