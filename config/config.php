<?php

use Refaktor\Blog\BlogPostBySlugBoundary;
use Refaktor\Blog\BlogPostInteractor;
use Refaktor\Blog\BlogPostLatestPostsBoundary;
use Refaktor\Blog\EntityGateway\PDOMySQL\BlogPostEntityGateway;

$localConfig = require(__DIR__ . '/local.php');

return [
    'dic' => [
        'share' => [
            PDO::class,
            BlogPostInteractor::class
        ],
        'alias' => [
            BlogPostBySlugBoundary::class      => BlogPostInteractor::class,
            BlogPostLatestPostsBoundary::class => BlogPostInteractor::class,
        ],
        'params' => [
            PDO::class => [
                'dsn'      => $localConfig['pdo']['dsn'],
                'username' => $localConfig['pdo']['username'],
                'passwd'   => $localConfig['pdo']['password'],
            ],
        ],
    ],
    'versionedGateways' => [
        BlogPostEntityGateway::class
    ],
];