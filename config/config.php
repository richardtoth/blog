<?php

use Refaktor\Blog\DeliveryMechanism\Web\Templating\ControllerTemplatingEngine;
use Refaktor\Blog\DeliveryMechanism\Web\Templating\TwigControllerTemplatingEngine;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Refaktor\Blog\BlogPostBySlugBoundary;
use Refaktor\Blog\BlogPostBySlugGateway;
use Refaktor\Blog\BlogPostInteractor;
use Refaktor\Blog\BlogPostLatestPostsBoundary;
use Refaktor\Blog\BlogPostLatestPostsGateway;
use Refaktor\Blog\DeliveryMechanism\Web\HTTP\GuzzleHTTPAdapter;
use Refaktor\Blog\DeliveryMechanism\Web\HTTP\HTTPAdapter;
use Refaktor\Blog\DeliveryMechanism\Web\Routing\FastRouteRouter;
use Refaktor\Blog\DeliveryMechanism\Web\Routing\Router;
use Refaktor\Blog\EntityGateway\PDOMySQL\BlogPostEntityGateway;

$localConfig = require(__DIR__ . '/local.php');

return [
    'dic' => [
        'share' => [
            PDO::class,
            BlogPostInteractor::class,
            BlogPostEntityGateway::class,
            GuzzleHTTPAdapter::class,
        ],
        'alias' => [
            BlogPostBySlugBoundary::class      => BlogPostInteractor::class,
            BlogPostLatestPostsBoundary::class => BlogPostInteractor::class,
            HTTPAdapter::class                 => GuzzleHTTPAdapter::class,
            Router::class                      => FastRouteRouter::class,
            ServerRequestInterface::class      => ServerRequest::class,
            BlogPostBySlugGateway::class       => BlogPostEntityGateway::class,
            BlogPostLatestPostsGateway::class  => BlogPostEntityGateway::class,
            ControllerTemplatingEngine::class  => TwigControllerTemplatingEngine::class,
        ],
        'params' => [
            PDO::class => [
                'dsn'      => $localConfig['pdo']['dsn'],
                'username' => $localConfig['pdo']['username'],
                'passwd'   => $localConfig['pdo']['password'],
            ],
            FastRouteRouter::class => require(__DIR__ . '/routing.php'),
            TwigControllerTemplatingEngine::class => [
                'templateDirectory' => __DIR__ . '/../src/DeliveryMechanism/Web/Controller',
                'trimControllerName' => [
                    'Refaktor\\Blog\\DeliveryMechanism\\Web\\Controller'
                ],
                'trimActionName' => [
                    'Action'
                ]
            ],
        ],
    ],
    'versionedGateways' => [
        BlogPostEntityGateway::class
    ],
];