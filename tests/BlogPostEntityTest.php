<?php

namespace Refaktor\Blog;

/**
 * @covers Refaktor\Blog\BlogPostEntity
 */
class BlogPostEntityTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Refaktor\Blog\BlogPostEntity::setSlug
     * @covers Refaktor\Blog\BlogPostEntity::getSlug
     */
    public function testSetGetSlug() {
        //setup
        $BlogPostEntity = new BlogPostEntity();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPostEntity', $BlogPostEntity->setSlug('test'));
        $this->assertEquals('test', $BlogPostEntity->getSlug());
    }

    /**
     * @covers Refaktor\Blog\BlogPostEntity::setTitle
     * @covers Refaktor\Blog\BlogPostEntity::getTitle
     */
    public function testSetGetTitle() {
        //setup
        $BlogPostEntity = new BlogPostEntity();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPostEntity', $BlogPostEntity->setTitle('test'));
        $this->assertEquals('test', $BlogPostEntity->getTitle());
    }

    /**
     * @covers Refaktor\Blog\BlogPostEntity::setContent
     * @covers Refaktor\Blog\BlogPostEntity::getContent
     */
    public function testSetGetContent() {
        //setup
        $BlogPostEntity = new BlogPostEntity();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPostEntity', $BlogPostEntity->setContent('test content'));
        $this->assertEquals('test content', $BlogPostEntity->getContent());
    }

    /**
     * @covers Refaktor\Blog\BlogPostEntity::setTitle
     */
    public function testNoAutoSlug() {
        //setup
        $BlogPostEntity = new BlogPostEntity();
        //act
        $BlogPostEntity->setTitle('This is my test blog post');
        //assert
        $this->assertEquals('', $BlogPostEntity->getSlug());
    }

    /**
     * @covers Refaktor\Blog\BlogPostEntity::setAuthor
     * @covers Refaktor\Blog\BlogPostEntity::getAuthor
     */
    public function testAuthor() {
        //setup
        $BlogPostEntity = new BlogPostEntity();
        $author   = new BlogAuthorEntity();
        //act
        //assert
        $this->assertEquals($BlogPostEntity, $BlogPostEntity->setAuthor($author));
        $this->assertEquals($author,   $BlogPostEntity->getAuthor());
    }
    
    /**
     * @covers Refaktor\Blog\BlogPostEntity::setPublishedAt
     * @covers Refaktor\Blog\BlogPostEntity::getPublishedAt
     */    
    public function testPublishDate() {
        //setup
        $BlogPostEntity = new BlogPostEntity();
        $publishDate = new \DateTime();
        //act
        //assert
        $this->assertEquals($BlogPostEntity, $BlogPostEntity->setPublishedAt($publishDate));
        $this->assertEquals($publishDate, $BlogPostEntity->getPublishedAt());
    }
}