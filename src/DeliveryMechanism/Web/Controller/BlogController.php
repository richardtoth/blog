<?php

namespace DeliveryMechanism\Web\Controller;

use Refaktor\Blog\BlogPostBySlugBoundary;
use Refaktor\Blog\BlogPostLatestPostsBoundary;

class BlogController {
    public function indexAction(BlogPostLatestPostsBoundary $latestPostsBoundary) {
        return [
            'blogPosts' => $latestPostsBoundary->getLatestPosts()->getBlogPosts(),
        ];
    }

    public function postAction($slug, BlogPostBySlugBoundary $bySlugBoundary) {
        return [
            'blogPost' => $bySlugBoundary->getBlogPostBySlug($slug)->getBlogPost(),
        ];
    }
}