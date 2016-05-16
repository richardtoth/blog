<?php

namespace Refaktor\Blog;

/**
 * @covers Refaktor\Blog\BlogPostResponseObject
 */
class BlogPostResponseObjectTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Refaktor\Blog\BlogPostResponseObject::setSlug
     * @covers Refaktor\Blog\BlogPostResponseObject::getSlug
     */
    public function testSetGetSlug() {
        //setup
        $blogPost = new BlogPostResponseObject();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPostResponseObject', $blogPost->setSlug('test'));
        $this->assertEquals('test', $blogPost->getSlug());
    }

    /**
     * @covers Refaktor\Blog\BlogPostResponseObject::setTitle
     * @covers Refaktor\Blog\BlogPostResponseObject::getTitle
     */
    public function testSetGetTitle() {
        //setup
        $blogPost = new BlogPostResponseObject();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPostResponseObject', $blogPost->setTitle('test'));
        $this->assertEquals('test', $blogPost->getTitle());
    }

    /**
     * @covers Refaktor\Blog\BlogPostResponseObject::setContent
     * @covers Refaktor\Blog\BlogPostResponseObject::getContent
     */
    public function testSetGetContent() {
        //setup
        $blogPost = new BlogPostResponseObject();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPostResponseObject', $blogPost->setContent('test content'));
        $this->assertEquals('test content', $blogPost->getContent());
    }

    /**
     * @covers Refaktor\Blog\BlogPostResponseObject::setTitle
     */
    public function testNoAutoSlug() {
        //setup
        $blogPost = new BlogPostResponseObject();
        //act
        $blogPost->setTitle('This is my test blog post');
        //assert
        $this->assertEquals('', $blogPost->getSlug());
    }

    /**
     * @covers Refaktor\Blog\BlogPostResponseObject::setAuthor
     * @covers Refaktor\Blog\BlogPostResponseObject::getAuthor
     */
    public function testAuthor() {
        //setup
        $blogPost = new BlogPostResponseObject();
        $author   = new BlogAuthorResponseObject();
        //act
        //assert
        $this->assertEquals($blogPost, $blogPost->setAuthor($author));
        $this->assertEquals($author,   $blogPost->getAuthor());
    }

    /**
     * @covers Refaktor\Blog\BlogPostResponseObject::setPublishedAt
     * @covers Refaktor\Blog\BlogPostResponseObject::getPublishedAt
     */
    public function testPublishDate() {
        //setup
        $blogPost = new BlogPostResponseObject();
        $publishDate = new \DateTime();
        //act
        //assert
        $this->assertEquals($blogPost, $blogPost->setPublishedAt($publishDate));
        $this->assertEquals($publishDate, $blogPost->getPublishedAt());
    }
}