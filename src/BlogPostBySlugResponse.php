<?php

namespace Refaktor\Blog;

/**
 * This class represents the response to a fetch request to an interactor.
 * 
 * @see BlogPostFetchingBoundaryInterface
 */
class BlogPostBySlugResponse {
    /**
     * @var BlogPostResponseObject
     */
    private $blogPost;

    public function __construct(BlogPostResponseObject $blogPost) {
        $this->setBlogPost($blogPost);
    }

    /**
     * @return BlogPostResponseObject
     */
    public function getBlogPost() {
        return $this->blogPost;
    }

    /**
     * @param BlogPostResponseObject $blogPost
     *
     * @return $this
     */
    public function setBlogPost($blogPost) {
        $this->blogPost = $blogPost;

        return $this;
    }
}