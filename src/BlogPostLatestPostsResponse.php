<?php

namespace Refaktor\Blog;

/**
 * This class declares the data that is returned from a listing requst.
 *
 * @see BlogPostLatestPostsBoundaryInterface
 */
class BlogPostLatestPostsResponse {
    /**
     * @var BlogPostResponseObject[]
     */
    private $blogPosts = array();

    /**
     * @param BlogPostResponseObject[] $blogPosts
     */
    public function __construct($blogPosts) {
        $this->setBlogPosts($blogPosts);
    }

    /**
     * @return BlogPostResponseObject[]
     */
    public function getBlogPosts() {
        return $this->blogPosts;
    }

    /**
     * @param BlogPostResponseObject[] $blogPosts
     *
     * @return $this
     */
    public function setBlogPosts($blogPosts) {
        if (!\is_array($blogPosts)) {
            throw new \BadMethodCallException('The $blogPost argument to ' . __METHOD__ . ' must contain an ' .
                'array with only BlogPostResponseObject objects in it');
        }
        foreach ($blogPosts as $blogPost) {
            if (!$blogPost instanceof BlogPostResponseObject) {
                throw new \BadMethodCallException('The $blogPost argument to ' . __METHOD__ . ' must contain an ' .
                    'array with only BlogPostResponseObject objects in it');
            }
        }

        $this->blogPosts = $blogPosts;

        return $this;
    }
}