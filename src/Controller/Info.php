<?php

namespace App\Controller;

use App\App;
use App\Service\Translation\ChainTranslator;
use App\Service\Translation\Request;
use App\Service\Translation\Response as TranslationResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use React\Http\Message\Response;

class Info
{
    public const VERSION = "1.0";

    public function __invoke(ServerRequestInterface $request)
    {
        try {
            $parsed = $request->getParsedBody();
            $translationRequest = new Request($parsed['lang_from'], $parsed['text_from']);

            if (!empty($parsed['domain'])) {
                $translationRequest->addMetaData('domain', $parsed['domain']);
            }
            if (!empty($parsed['param1'])) {
                $translationRequest->addMetaData('user-agent', $parsed['param1']);
            }

            /**
             * @var ChainTranslator $translator
             */
            $translator = App::get(ChainTranslator::class);

            return $translator->translate($translationRequest)->then(
                function (TranslationResponse $response) use ($request, $translationRequest) {
                    App::get(LoggerInterface::class)->info($translationRequest . ' => ' . $response->getTranslated());
                    if ($response->isOk()) {
                        return new Response(200, ['Content-type' => 'application/json'], json_encode(['version' => self::VERSION, 'response' => $response->getTranslated(), 'request' => $request->getParsedBody()]));
                    } else {
                        if ($response->isError()) {
                            return new Response(400, ['Content-type' => 'application/json'], json_encode(['version' => self::VERSION, 'error' => $response->getError(), 'request' => $request->getParsedBody()]));
                        } else {
                            return new Response(404, ['Content-type' => 'application/json'], json_encode(['version' => self::VERSION, 'request' => $request->getParsedBody()]));
                        }
                    }
                },
                function ($reason) {
                    return new Response(500, ['Content-type' => 'application/json'], json_encode(['error' => json_encode($reason)]));
                }
            );
        } catch (\Throwable $e) {
            return new Response(500, ['Content-type' => 'application/json'], json_encode(['error' => json_encode($e->getMessage())]));
        }
    }
}
