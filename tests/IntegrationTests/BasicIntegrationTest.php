<?php

namespace Refaktor\Blog\IntegrationTests;

use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Session;

class BasicIntegrationTest extends \PHPUnit_Framework_TestCase {
    public function testBlog() {
        try {
            $config = @include(__DIR__ . '/../../config/test.php');
            if (!$config) {
                $this->markTestIncomplete('Missing integration test config');
                return;
            }

            $session = new Session(new Selenium2Driver('firefox', null, $config['seleniumServer']));

            $session->start();

            $session->visit($config['integrationTestUrl']);

            $this->assertEquals($config['integrationTestUrl'], $session->getCurrentUrl());

            $page = $session->getPage();
            $this->assertEquals('This is my second post', $page->find('css', 'h2')->getText());
            $page->find('css', 'h2 a')->click();

            $this->assertEquals($config['integrationTestUrl'] . 'second-post', $session->getCurrentUrl());

            $session->stop();
        } catch (DriverException $e) {
            $this->markTestSkipped('Selenium server not running, skipping tests.');
        }
    }
}