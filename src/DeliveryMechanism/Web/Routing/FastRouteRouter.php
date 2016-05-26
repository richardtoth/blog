<?php

namespace Refaktor\Blog\DeliveryMechanism\Web\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Http\Message\ServerRequestInterface;

class FastRouteRouter implements Router {
    /**
     * @var \FastRoute\Dispatcher
     */
    private $dispatcher;
    /**
     * @var array
     */
    private $errorHandlers = [];

    public function __construct($routes, $errorHandlers) {
        $this->dispatcher    = \FastRoute\simpleDispatcher(function (RouteCollector $routeCollector) use ($routes) {
            foreach ($routes as $route) {
                $method   = $route[0];
                $uri      = $route[1];
                $callback = array($route[2], $route[3]);
                $routeCollector->addRoute($method, $uri, $callback);
            }
        });
        $this->errorHandlers = $errorHandlers;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return RoutingResponse
     * @throws \Exception
     */
    public function route(ServerRequestInterface $request) {
        $vars = [];

        $httpMethod = $request->getMethod();
        $uri        = $request->getUri()->getPath();

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $statusCode = 404;
                $controller = $this->errorHandlers[404][0];
                $action     = $this->errorHandlers[404][1];
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $statusCode             = 405;
                $vars['allowedMethods'] = $routeInfo[1];
                $controller             = $this->errorHandlers[405][0];
                $action                 = $this->errorHandlers[405][1];
                break;
            case Dispatcher::FOUND:
                $statusCode = 200;
                $controller = $routeInfo[1][0];
                $action     = $routeInfo[1][1];
                $vars       = $routeInfo[2];
                break;
            default:
                throw new \Exception('Routing error!');
        }

        return new RoutingResponse($statusCode, $controller, $action, $vars);
    }

    public function getNotFoundRoute() {
        $statusCode = 404;
        $controller = $this->errorHandlers[404][0];
        $action     = $this->errorHandlers[404][1];

        return new RoutingResponse($statusCode, $controller, $action, []);
    }
}
