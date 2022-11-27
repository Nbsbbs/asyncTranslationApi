<?php

namespace Nbsbbs\Common\Language;

interface LanguageInterface
{
    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getSlug(): string;

    /**
     * @return bool
     */
    public function isRightToLeft(): bool;

    /**
     * @return int
     */
    public function getWeght(): int;
}
