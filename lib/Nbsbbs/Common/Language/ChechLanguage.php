<?php

namespace Nbsbbs\Common\Language;

class ChechLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'cs';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'Čeština';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'cs';
    }

    /**
     * @inheritDoc
     */
    public function isRightToLeft(): bool
    {
        return false;
    }
}
