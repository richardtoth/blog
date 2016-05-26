<?php

namespace Refaktor\Blog\DeliveryMechanism\Web\Routing;

use Psr\Http\Message\ServerRequestInterface;

interface Router {
    /**
     * @param ServerRequestInterface $request
     *
     * @return RoutingResponse
     */
    public function route(ServerRequestInterface $request);

    /**
     * @return RoutingResponse
     */
    public function getNotFoundRoute();
}