<?php

namespace Refaktor\Blog;

/**
 * @covers Refaktor\Blog\BlogPostLatestPostsResponse
 */
class BlogPostLatestPostsResponseTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers Refaktor\Blog\BlogPostLatestPostsResponse::__construct
     * @covers Refaktor\Blog\BlogPostLatestPostsResponse::getBlogPosts
     */
    public function testConstructgetBlogPosts() {
        //setup
        $blogPosts = array(new BlogPostResponseObject());
        $response  = new BlogPostLatestPostsResponse($blogPosts);
        //act
        //assert
        $this->assertEquals($blogPosts, $response->getBlogPosts());
    }

    /**
     * @covers Refaktor\Blog\BlogPostLatestPostsResponse::setBlogPosts
     * @covers Refaktor\Blog\BlogPostLatestPostsResponse::getBlogPosts
     */
    public function testSetGetBlogPosts() {
        //setup
        $blogPosts1 = array(new BlogPostResponseObject());
        $blogPosts2 = array(new BlogPostResponseObject());
        $response  = new BlogPostLatestPostsResponse($blogPosts1);
        //act
        
        //assert
        $this->assertEquals($response, $response->setBlogPosts($blogPosts2));
        $this->assertFalse($blogPosts1 === $response->getBlogPosts());
        $this->assertTrue($blogPosts2 === $response->getBlogPosts());
    }

    /**
     * @covers Refaktor\Blog\BlogPostLatestPostsResponse::__construct
     */
    public function testConstructorTypeChecking() {
        $blogPosts = 'yada';
        try {
            /** @noinspection PhpParamsInspection */
            new BlogPostLatestPostsResponse($blogPosts);
            $this->fail('Calling BlogPostLatestPostsResponse constructor with an invalid argument doesn\'t result ' .
            'in an exception.');
        } catch (\BadMethodCallException $e) {
            //pass
        }
    }

    /**
     * @covers Refaktor\Blog\BlogPostLatestPostsResponse::__construct
     */
    public function testConstructorTypeCheckingWithArray() {
        $blogPosts = array('yada');
        try {
            new BlogPostLatestPostsResponse($blogPosts);
            $this->fail('Calling BlogPostLatestPostsResponse constructor with an invalid argument doesn\'t result ' .
                'in an exception.');
        } catch (\BadMethodCallException $e) {
            //pass
        }
    }

    /**
     * @covers Refaktor\Blog\BlogPostLatestPostsResponse::setBlogPosts
     */
    public function testSetterTypeChecking() {
        //setup
        $response = new BlogPostLatestPostsResponse(array());
        $blogPosts = 'yada';
        //assert
        try {
            /** @noinspection PhpParamsInspection */
            $response->setBlogPosts($blogPosts);
            $this->fail('Calling BlogPostLatestPostsResponse setter with an invalid argument doesn\'t result ' .
                'in an exception.');
        } catch (\BadMethodCallException $e) {
            //pass
        }
    }

    /**
     * @covers Refaktor\Blog\BlogPostLatestPostsResponse::setBlogPosts
     */
    public function testSetterTypeCheckingWithArray() {
        //setup
        $response = new BlogPostLatestPostsResponse(array());
        $blogPosts = array('yada');
        //assert
        try {
            $response->setBlogPosts($blogPosts);
            $this->fail('Calling BlogPostLatestPostsResponse setter with an invalid argument doesn\'t result ' .
                'in an exception.');
        } catch (\BadMethodCallException $e) {
            //pass
        }
    }
}