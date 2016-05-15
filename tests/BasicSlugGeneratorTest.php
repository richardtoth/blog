<?php

namespace Refaktor\Blog;

class BasicSlugGeneratorTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers Refaktor\Blog\BasicSlugGenerator::generateSlug
     */
    public function testCreateSlug() {
        //setup
        $basicSlugGenerator = new BasicSlugGenerator();
        //act
        //assert
        $this->assertEquals('this-is-my-test-blog-post', $basicSlugGenerator->generateSlug('This is my test blog post'));
    }

    /**
     * @covers Refaktor\Blog\BasicSlugGenerator::generateSlug
     */
    public function testHungarianCharacters() {
        //setup
        $basicSlugGenerator = new BasicSlugGenerator();
        //act
        //assert
        $this->assertEquals('arvizturo-tukorfurogep', $basicSlugGenerator->generateSlug('Árvíztűrő tükörfúrógép'));
    }
}