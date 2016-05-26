<?php

namespace Refaktor\Blog\DeliveryMechanism\Web\Controller;

use Refaktor\Blog\BlogPostBySlugBoundary;
use Refaktor\Blog\BlogPostBySlugBoundaryException;
use Refaktor\Blog\BlogPostLatestPostsBoundary;
use Refaktor\Blog\DeliveryMechanism\Web\NotFoundException;

class BlogController {
    public function indexAction(BlogPostLatestPostsBoundary $latestPostsBoundary) {
        return [
            'blogPosts' => $latestPostsBoundary->getLatestPosts()->getBlogPosts(),
        ];
    }

    public function postAction($slug, BlogPostBySlugBoundary $bySlugBoundary) {
        try {
            return [
                'blogPost' => $bySlugBoundary->getBlogPostBySlug($slug)->getBlogPost(),
            ];
        } catch (BlogPostBySlugBoundaryException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }
}