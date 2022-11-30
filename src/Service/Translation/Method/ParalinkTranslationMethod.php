<?php

namespace App\Service\Translation\Method;

use App\Service\Translation\Request;
use App\Service\Translation\Response;
use Psr\Http\Message\ResponseInterface;
use React\Http\Browser;
use React\Promise\PromiseInterface;

class ParalinkTranslationMethod implements BasicTranslatorInterface
{
    private const TIMEOUT = 4;
    public const SOURCE_ID = 'paralink';
    private const API_URL = 'https://translation2.paralink.com/do.asp';

    /**
     * @var Browser
     */
    private Browser $browser;

    /**
     * @param Browser $browser
     */
    public function __construct(Browser $browser)
    {
        $this->browser = $browser->withTimeout(self::TIMEOUT);
    }

    /**
     * @param Request $request
     * @return PromiseInterface
     */
    public function translate(Request $request): PromiseInterface
    {
        $requestData = [
            'actions' => 'translate',
            'src' => $request->getQuery(),
            'provider' => 'google',
            'ctrl' => 'target',
            'dir' => $request->getLanguage() . '/' . $request->getTargetLanguage(),
        ];

        return $this->browser->post(
            self::API_URL,
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            http_build_query($requestData)
        )->then(
            function (ResponseInterface $response) use ($request) {
                $parsed = $this->parseResponse($response->getBody()->getContents());
                if (!is_null($parsed)) {
                    $result = new Response($request, $parsed);
                } else {
                    $result = new Response($request);
                }
                return $result->withSource(self::SOURCE_ID);
            },
            function (\Exception $exception) use ($request) {
                return (new Response($request))->withError($exception->getMessage())->withSource(self::SOURCE_ID);
            });
    }

    /**
     * @param string $response
     * @return string|null
     */
    protected function parseResponse(string $response): ?string
    {
        if (preg_match('#<script>top\.GEBI\(\'target\'\)\.value="([^"]+)";#s', $response, $args)) {
            return $args[1];
        } else {
            return null;
        }
    }
}
