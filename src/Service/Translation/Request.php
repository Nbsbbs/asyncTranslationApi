<?php

namespace App\Service\Translation;

use Nbsbbs\Common\Language\LanguageFactory;

class Request
{
    /**
     * @var string
     */
    private string $langCode;

    /**
     * @var string
     */
    private string $targetLangCode;

    /**
     * @var string
     */
    private string $query;

    /**
     * @var array
     */
    private array $params = [];

    /**
     * @param string $langCode
     * @param string $query
     */
    public function __construct(string $langCode, string $query, string $targetLangCode = 'en')
    {
        $this->validateLanguageCode($langCode);
        $this->validateLanguageCode($targetLangCode);
        $normalized = $this->normalizeQuery($query);
        $this->validateQuery($normalized);
        $this->langCode = $langCode;
        $this->targetLangCode = $targetLangCode;
        $this->query = $normalized;
    }

    /**
     * @param string $index
     * @param string $value
     * @return void
     */
    public function addMetaData(string $index, string $value)
    {
        $this->params[$index] = $value;
    }

    /**
     * @return array
     */
    public function getMetaData(): array
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->langCode;
    }

    /**
     * @return string
     */
    public function getTargetLanguage(): string
    {
        return $this->targetLangCode;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function hash(): string
    {
        return md5($this->langCode . ':' . $this->targetLangCode . ':' . $this->query);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('Translation from "%s" to "%s", query "%s"', $this->langCode, $this->targetLangCode, $this->query);
    }

    /**
     * @param string $query
     * @return string
     */
    protected function normalizeQuery(string $query): string
    {
        $text = mb_convert_case($query, MB_CASE_LOWER, "UTF-8");
        $text = preg_replace("#\s+#s", " ", $text);
        $text = preg_replace("#([\d\s]+)$#s", "", $text);
        $text = trim($text);
        $words = explode(' ', $text);
        $words = array_unique($words);
        $text = implode(' ', $words);
        return $text;
    }

    /**
     * @param string $code
     * @return void
     */
    protected function validateLanguageCode(string $code): void
    {
        if (!LanguageFactory::isValidCode($code)) {
            throw new \InvalidArgumentException('Language code not supported');
        }
    }

    /**
     * @param string $query
     * @return void
     */
    protected function validateQuery(string $query): void
    {
        if (mb_strlen($query) < 2) {
            throw new \InvalidArgumentException('Query too short');
        }
    }
}