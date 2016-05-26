<?php

namespace Refaktor\Blog;

class BlogPostInteractor implements BlogPostLatestPostsBoundary, BlogPostBySlugBoundary {

    /**
     * @var BlogPostBySlugGateway
     */
    private $bySlugGateway;

    /**
     * @var BlogPostLatestPostsGateway
     */
    private $latestPostsGateway;

    /**
     * @param BlogPostBySlugGateway      $bySlugGateway
     * @param BlogPostLatestPostsGateway $latestPostsGateway
     */
    public function __construct(
        BlogPostBySlugGateway $bySlugGateway,
        BlogPostLatestPostsGateway $latestPostsGateway
    ) {
        $this->bySlugGateway      = $bySlugGateway;
        $this->latestPostsGateway = $latestPostsGateway;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlogPostBySlug($slug) {
        try {
            $postEntity   = $this->bySlugGateway->getBySlug($slug);
            $responsePost = $this->translateEntityToResponse($postEntity);
            return new BlogPostBySlugResponse($responsePost);
        } catch (EntityNotFoundException $e) {
            throw new BlogPostNotFoundBoundaryException('Blog post not found by slug: \'' . $slug . '\'', 0, $e);
        }
    }

    protected function translateEntityToResponse(BlogPostEntity $entity) {
        $responsePost   = new BlogPostResponseObject();
        $responseAuthor = new BlogAuthorResponseObject();
        $responseAuthor->setName($entity->getAuthor()->getName());
        $responsePost
            ->setSlug($entity->getSlug())
            ->setTitle($entity->getTitle())
            ->setPublishedAt(clone $entity->getPublishedAt())
            ->setContent($entity->getContent())
            ->setAuthor($responseAuthor);
        return $responsePost;
    }

    /**
     * {@inheritdoc}
     */
    public function getLatestPosts($limit = null, $offset = null) {
        $posts = $this->latestPostsGateway->getOrderedByDate($limit, $offset);

        $latestPosts = array();
        foreach ($posts as $post) {
            $latestPosts[] = $this->translateEntityToResponse($post);
        }
        $response = new BlogPostLatestPostsResponse($latestPosts);
        return $response;
    }
}
