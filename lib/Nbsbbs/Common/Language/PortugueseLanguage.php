<?php

namespace Nbsbbs\Common\Language;

class PortugueseLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'pt';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Português';
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
