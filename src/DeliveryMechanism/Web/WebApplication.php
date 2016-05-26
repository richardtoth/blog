<?php

namespace Refaktor\Blog\DeliveryMechanism\Web;

use Refaktor\Blog\DeliveryMechanism\Web\Templating\ControllerTemplatingEngine;
use MongoDB\Driver\Server;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Refaktor\Blog\DeliveryMechanism\Application;
use Refaktor\Blog\DeliveryMechanism\Web\HTTP\HTTPAdapter;
use Refaktor\Blog\DeliveryMechanism\Web\Routing\Router;
use Refaktor\Blog\DependencyInjection\DependencyInjectionContainer;

class WebApplication extends Application {
    public function execute($server, $get, $post, $cookie, $files) {
        /**
         * @var ServerRequestInterface $request
         * @var HTTPAdapter $httpAdapter
         */
        list($request, $httpAdapter) = $this->initRequest($server, $get, $post, $cookie, $files, $this->getDIC());

        list($controllerResponse, $controllerClass, $controllerMethod) =
            $this->processRoutingToController($this->getDIC());

        $this->processView($controllerClass, $controllerMethod, $controllerResponse, $httpAdapter);

        $this->sendOutput($httpAdapter->getResponse());
    }
    
    private function initRequest($server, $get, $post, $cookie, $files, DependencyInjectionContainer $dic) {
        $dic->setClassParameters(HTTPAdapter::class, [
            'server' => $server,
            'get'    => $get,
            'post'   => $post,
            'cookie' => $cookie,
            'files'  => $files,
        ]);

        /**
         * @var HTTPAdapter $httpAdapter
         */
        $httpAdapter = $dic->make(HTTPAdapter::class);

        $request = $httpAdapter->getRequest();

        //Make accessing the request and the URI simpler
        $dic->share($request);
        $dic->share($request->getUri());

        return [$request, $httpAdapter];
    }

    private function processRoutingToController(DependencyInjectionContainer $dic) {
        /**
         * @var Router $router
         */
        $router  = $dic->make(Router::class);

        /**
         * @var ServerRequestInterface $request
         */
        $request = $dic->make(ServerRequestInterface::class);
        $routingResponse = $router->route($request);

        $controllerMethod = $routingResponse->getControllerMethod();
        $controller = $dic->make($routingResponse->getControllerClass());

        try {
            $controllerResponse = $dic->execute(
                [$controller, $controllerMethod],
                $routingResponse->getParameters());
        } catch (NotFoundException $e) {
            $routingResponse = $router->getNotFoundRoute();
            $controllerResponse = $dic->execute(
                [$routingResponse->getControllerClass(), $routingResponse->getControllerMethod()],
                $routingResponse->getParameters());
        }

        return [$controllerResponse,
            $routingResponse->getControllerClass(),
            $routingResponse->getControllerMethod()
        ];
    }
    
    private function processView($controllerClass, $controllerMethod, $controllerResponse, HTTPAdapter $httpAdapter) {
        if (!$controllerResponse instanceof ResponseInterface) {
            if (is_string($controllerResponse)) {
                //Standard text response, no view rendering
                //PSR-7 bullshit, don't ask
                $httpAdapter->overrideResponse(
                    $httpAdapter->getResponse()->withBody(
                        $httpAdapter->getStringStream($controllerResponse)));
            } else {
                //Data response, pass to view

                /**
                 * @var ControllerTemplatingEngine $view
                 */
                $view = $this->getDIC()->make(ControllerTemplatingEngine::class);

                $body = $view->render($controllerClass, $controllerMethod, $controllerResponse);

                $httpAdapter->overrideResponse(
                    $httpAdapter->getResponse()->withBody(
                        $httpAdapter->getStringStream($body)));
            }
        } else {
            $httpAdapter->overrideResponse($controllerResponse);
        }
    }

    private function sendOutput(ResponseInterface $httpResponse) {
        header(
            'HTTP/' . $httpResponse->getProtocolVersion() . ' ' .
            $httpResponse->getStatusCode() . ' ' .
            $httpResponse->getReasonPhrase());
        foreach ($httpResponse->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }
        echo $httpResponse->getBody();
    }
}