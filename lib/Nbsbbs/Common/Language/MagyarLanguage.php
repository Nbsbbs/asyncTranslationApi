<?php

namespace Nbsbbs\Common\Language;

class MagyarLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'hu';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Magyar';
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
