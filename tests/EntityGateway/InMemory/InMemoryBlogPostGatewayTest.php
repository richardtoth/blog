<?php

namespace Refaktor\Blog\EntityGateway\InMemory;
use Refaktor\Blog\BlogPostEntity;
use Refaktor\Blog\EntityNotFoundException;

/**
 * @covers Refaktor\Blog\EntityGateway\InMemory\InMemoryBlogPostGateway
 */
class InMemoryBlogPostGatewayTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers Refaktor\Blog\EntityGateway\InMemory\InMemoryBlogPostGateway::getBySlug()
     */
    public function testGetBySlug() {
        //setup
        $blogPost = new BlogPostEntity();
        $blogPost->setSlug('asdfasdf');
        $gateway = new InMemoryBlogPostGateway(array($blogPost));
        //act
        //assert
        $this->assertEquals($blogPost, $gateway->getBySlug('asdfasdf'));
    }

    /**
     * @covers Refaktor\Blog\EntityGateway\InMemory\InMemoryBlogPostGateway::getBySlug()
     */
    public function testGetBySlugNotFound() {
        //setup
        $blogPost = new BlogPostEntity();
        $blogPost->setSlug('asdfasdf');
        $gateway = new InMemoryBlogPostGateway(array($blogPost));
        //act
        //assert
        try {
            $gateway->getBySlug('yada');
            $this->fail('getBySlug on a non-existent slug didn\'t result in an exception');
        } catch (EntityNotFoundException $e) {
            //pass
        }
    }

    /**
     * @covers Refaktor\Blog\EntityGateway\InMemory\InMemoryBlogPostGateway::getOrderedByDate
     */
    public function testGetOrderedByDate() {
        //setup
        $blogPost1 = new BlogPostEntity();
        $blogPost1->setSlug('test1');
        $blogPost1->setPublishedAt(new \DateTime('1970-01-01 00:00:00'));
        $blogPost2 = new BlogPostEntity();
        $blogPost2->setSlug('test2');
        $blogPost2->setPublishedAt(new \DateTime('1970-01-01 00:00:01'));
        $gateway = new InMemoryBlogPostGateway(array($blogPost1, $blogPost2));
        //act
        $blogPosts = $gateway->getOrderedByDate();
        //assert
        $this->assertEquals(2, count($blogPosts));
        $this->assertEquals('test2', $blogPosts[0]->getSlug());
        $this->assertEquals('test1', $blogPosts[1]->getSlug());
    }

    /**
     * @covers Refaktor\Blog\EntityGateway\InMemory\InMemoryBlogPostGateway::getOrderedByDate
     */
    public function testGetOrderedByDateWithLimit() {
        //setup
        $blogPost1 = new BlogPostEntity();
        $blogPost1->setSlug('test1');
        $blogPost1->setPublishedAt(new \DateTime('1970-01-01 00:00:00'));
        $blogPost2 = new BlogPostEntity();
        $blogPost2->setSlug('test2');
        $blogPost2->setPublishedAt(new \DateTime('1970-01-01 00:00:01'));
        $blogPost3 = new BlogPostEntity();
        $blogPost3->setSlug('test3');
        $blogPost3->setPublishedAt(new \DateTime('1970-01-01 00:00:02'));
        $gateway = new InMemoryBlogPostGateway(array($blogPost2, $blogPost1, $blogPost3));
        //act
        $blogPosts = $gateway->getOrderedByDate(1, 1);
        //assert
        $this->assertEquals(1, count($blogPosts));
        $this->assertEquals('test2', $blogPosts[0]->getSlug());
    }
}