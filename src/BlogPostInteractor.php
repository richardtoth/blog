<?php

namespace Refaktor\Blog;

class BlogPostInteractor implements BlogPostLatestPostsBoundaryInterface, BlogPostBySlugBoundaryInterface {

    /**
     * @var BlogPostBySlugGatewayInterface
     */
    private $bySlugGateway;

    /**
     * @var BlogPostLatestPostsGatewayInterface
     */
    private $latestPostsGateway;

    /**
     * @param BlogPostBySlugGatewayInterface      $bySlugGateway
     * @param BlogPostLatestPostsGatewayInterface $latestPostsGateway
     */
    public function __construct(
        BlogPostBySlugGatewayInterface $bySlugGateway,
        BlogPostLatestPostsGatewayInterface $latestPostsGateway
    ) {
        $this->bySlugGateway      = $bySlugGateway;
        $this->latestPostsGateway = $latestPostsGateway;
    }

    protected function translateEntityToResponse(BlogPostEntity $entity) {
        $responsePost = new BlogPostResponseObject();
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
    public function getBlogPostBySlug($slug) {
        try {
            $postEntity   = $this->bySlugGateway->getBySlug($slug);
            $responsePost = $this->translateEntityToResponse($postEntity);
            return new BlogPostBySlugResponse($responsePost);
        } catch (EntityNotFoundException $e) {
            throw new BlogPostNotFoundBoundaryException('Blog post not found by slug: \'' . $slug . '\'', 0, $e);
        }


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
