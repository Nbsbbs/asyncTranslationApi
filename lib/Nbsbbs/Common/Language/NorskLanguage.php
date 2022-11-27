<?php

namespace Nbsbbs\Common\Language;

class NorskLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'no';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Norsk';
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
