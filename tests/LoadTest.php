<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 03/11/14
 */

namespace Kozz\Tests;

use Kozz\Components\Cache\StaticCache;
use Kozz\Tests\Mock\ExampleMock;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\Definition;

class LoadTest extends PHPUnit_Framework_TestCase{

  public function testLoad()
  {
    $this->assertTrue(class_exists('Kozz\Components\Cache\StaticCache'));
    $this->assertTrue(interface_exists('Kozz\Components\Cache\Repository\CacheRepositoryInterface'));
  }

  public function testInjection()
  {
    $original = new ExampleMock();
    $this->assertEquals(1, $original->getInstanceCounter());

    $injection = StaticCache::loadInjection('example_mock', new Definition('\Kozz\tests\Mock\ExampleMock'));
    $this->assertInstanceOf('\Kozz\tests\Mock\ExampleMock', $injection);
    $this->assertEquals(2, $original->getInstanceCounter());
    $this->assertEquals(2, $injection->getInstanceCounter());

    $injection2 = StaticCache::loadInjection('example_mock', new Definition('\Kozz\tests\Mock\ExampleMock'));
    $this->assertEquals(2, $original->getInstanceCounter());
    $this->assertEquals(2, $injection->getInstanceCounter());
    $this->assertEquals($injection, $injection2);
  }
} 