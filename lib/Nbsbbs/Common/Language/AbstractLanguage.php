<?php

namespace Nbsbbs\Common\Language;

abstract class AbstractLanguage implements LanguageInterface
{
    /**
     * @return string
     */
    abstract public function getCode(): string;

    /**
     * @return string
     */
    abstract public function getTitle(): string;

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->getCode();
    }

    /**
     * @return bool
     */
    public function isRightToLeft(): bool
    {
        return false;
    }

    /**
     * @return int
     */
    public function getWeght(): int
    {
        return 1;
    }
}
