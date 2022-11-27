<?php

namespace Nbsbbs\Common\Language;

class ArabicLanguage extends AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'ar';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return 'العربية';
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
        return true;
    }
}
