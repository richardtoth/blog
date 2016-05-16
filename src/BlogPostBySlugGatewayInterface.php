<?php

namespace Refaktor\Blog;

/**
 * This interface declares the functions required to fetch one BlogPost entity
 */
interface BlogPostBySlugGatewayInterface {
    /**
     * @param string $slug
     *
     * @return BlogPostEntity
     *
     * @throws EntityNotFoundException
     */
    public function getBySlug($slug);
}