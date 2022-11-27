<?php

namespace App;

use FastRoute\Dispatcher;
use FastRoute\Dispatcher\GroupCountBased;
use FastRoute\RouteCollector;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class Router
{
    /**
     * @var GroupCountBased
     */
    private GroupCountBased $dispatcher;

    /**
     * @param RouteCollector $routes
     */
    public function __construct(RouteCollector $routes)
    {
        $this->dispatcher = new GroupCountBased($routes->getData());
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return new Response(404, ['Content-Type' => 'text/plain'], 'Not found');
            case Dispatcher::METHOD_NOT_ALLOWED:
                return new Response(405, ['Content-Type' => 'text/plain'], 'Method not allowed');
            case Dispatcher::FOUND:
                $params = $routeInfo[2];
                $result = $routeInfo[1]($request, ... array_values($params));

                return $result;
        }

        throw new \LogicException('Something wrong with routing');
    }
}
