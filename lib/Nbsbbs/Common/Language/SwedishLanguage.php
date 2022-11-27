<?php

namespace Nbsbbs\Common\Language;

class SwedishLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'sv';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Svenska';
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
