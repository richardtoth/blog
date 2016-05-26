<?php

use Refaktor\Blog\DeliveryMechanism\Web\Controller\BlogController;
use Refaktor\Blog\DeliveryMechanism\Web\Controller\ErrorController;

return [
    'errorHandlers' => [
        404 => [ErrorController::class, 'notFound'],
        405 => [ErrorController::class, 'methodNotAllowed'],
    ],
    'routes' => [
        ['GET',  '/',                   BlogController::class, 'indexAction'],
        ['GET',  '/{slug:[a-zA-Z\-]+}', BlogController::class, 'postAction'],
    ],
];