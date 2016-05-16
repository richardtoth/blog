<?php

namespace Refaktor\Blog;

/**
 * This interface declares the functions the fetching interactor needs to implement.
 */
interface BlogPostBySlugBoundaryInterface {
    /**
     * @param string $slug
     *
     * @return BlogPostBySlugResponse
     *
     * @throws BlogPostNotFoundBoundaryException if the given blog post was not found / is not available
     */
    public function getBlogPostBySlug($slug);
}
