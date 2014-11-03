<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 03/11/14
 */

namespace Kozz\Tests;

use PHPUnit_Framework_TestCase;

class LoadTest extends PHPUnit_Framework_TestCase{

  public function testLoad()
  {
    $this->assertTrue(class_exists('Kozz\Components\Cache\StaticCache'));
    $this->assertTrue(interface_exists('Kozz\Components\Cache\Repository\CacheRepositoryInterface'));
  }
} 