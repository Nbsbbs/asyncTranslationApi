<?php

namespace App\Service\Translation;

use App\Service\Translation\Query\Normalizer;

class Response
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var string|null
     */
    private ?string $translated = null;

    /**
     * @var string|null
     */
    private ?string $source = 'unknown';

    /**
     * @var string|null
     */
    private ?string $error = null;

    /**
     * @param Request $request
     * @param string|null $translated
     */
    public function __construct(Request $request, ?string $translated = null)
    {
        $this->request = $request;
        if (!is_null($translated)) {
            $this->translated = Normalizer::normalize($translated);
        }
    }

    /**
     * @param string $message
     * @return $this
     */
    public function withError(string $message): self
    {
        $this->error = $message;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return string|null
     */
    public function getTranslated(): ?string
    {
        return $this->translated;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return $this
     */
    public function withSource(string $source): self
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return !is_null($this->translated) or !is_null($this->error);
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return !is_null($this->error);
    }
}
