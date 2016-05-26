<?php


namespace Refaktor\Blog;
use Refaktor\Blog\EntityGateway\InMemory\InMemoryBlogPostGateway;

/**
 * @covers Refaktor\Blog\BlogPostInteractor
 */
class BlogPostInteractorTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers Refaktor\Blog\BlogPostInteractor::getBlogPostBySlug
     */
    public function testGetBySlug() {
        //setup
        $postEntity = new BlogPostEntity();

        $authorEntity = new BlogAuthorEntity();
        $authorEntity->setName('John Doe');

        $postEntity->setSlug('yolo');
        $postEntity->setAuthor($authorEntity);
        $postEntity->setPublishedAt(new \DateTime());
        $postEntity->setTitle('My Yolo Blogpost!');
        $postEntity->setContent('Hello world!');

        $entityGateway = new InMemoryBlogPostGateway(array($postEntity));
        $interactor    = new BlogPostInteractor($entityGateway, $entityGateway);

        //act
        $response = $interactor->getBlogPostBySlug('yolo');
        $blogPost = $response->getBlogPost();
        $author   = $blogPost->getAuthor();

        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPostResponseObject', $blogPost);
        $this->assertInstanceOf('Refaktor\\Blog\\BlogAuthorResponseObject', $author);
        $this->assertEquals('yolo', $blogPost->getSlug());
        $this->assertEquals('John Doe', $author->getName());
        $this->assertEquals('My Yolo Blogpost!', $blogPost->getTitle());
        $this->assertEquals('Hello world!', $blogPost->getContent());
        $this->assertEquals($postEntity->getPublishedAt(), $blogPost->getPublishedAt());
    }

    /**
     * @covers Refaktor\Blog\BlogPostInteractor::getBlogPostBySlug
     */
    public function testGetBySlugIfNotFound() {
        //setup
        $entityGateway = new InMemoryBlogPostGateway(array());
        $interactor    = new BlogPostInteractor($entityGateway, $entityGateway);

        //act

        //assert
        try {
            $interactor->getBlogPostBySlug('yolo');
            $this->fail('Trying to get a non-existent blog post does not result in an exception');
        } catch (BlogPostNotFoundBoundaryException $e) {
            //pass
        }
    }

    /**
     *
     */
    public function testGetLatestPosts() {
        //setup
        $authorEntity = new BlogAuthorEntity();
        $authorEntity->setName('John Doe');

        $postEntity1 = new BlogPostEntity();
        $postEntity1->setSlug('first-post');
        $postEntity1->setAuthor($authorEntity);
        $postEntity1->setPublishedAt(new \DateTime('2016-01-01 00:00:00'));
        $postEntity1->setTitle('My first BlogPost!');
        $postEntity1->setContent('I\'m now blogging!');

        $postEntity2 = new BlogPostEntity();
        $postEntity2->setSlug('great-day');
        $postEntity2->setAuthor($authorEntity);
        $postEntity2->setPublishedAt(new \DateTime('2016-01-02 00:00:00'));
        $postEntity2->setTitle('Great day!');
        $postEntity2->setContent('Sun is shinin\'...');

        $entityGateway = new InMemoryBlogPostGateway(array($postEntity1, $postEntity2));
        $interactor    = new BlogPostInteractor($entityGateway, $entityGateway);

        //act
        $latestPosts = $interactor->getLatestPosts(1)->getBlogPosts();
        $blogPost = $latestPosts[0];
        $author = $blogPost->getAuthor();

        //assert
        $this->assertEquals(1, count($latestPosts));
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPostResponseObject', $blogPost);
        $this->assertInstanceOf('Refaktor\\Blog\\BlogAuthorResponseObject', $author);
        $this->assertEquals('great-day', $blogPost->getSlug());
        $this->assertEquals('John Doe', $author->getName());
        $this->assertEquals('Great day!', $blogPost->getTitle());
        $this->assertEquals('Sun is shinin\'...', $blogPost->getContent());
        $this->assertEquals(new \DateTime('2016-01-02 00:00:00'), $blogPost->getPublishedAt());
    }
}