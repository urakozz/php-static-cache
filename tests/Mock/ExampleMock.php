<?php
/**
 * @author Yury Kozyrev [https://github.com/urakozz]
 */

namespace Kozz\Tests\Mock;


class ExampleMock {

  protected static $constructed = 0;

  public function __construct()
  {
    ++self::$constructed;
  }

  public function getInstanceCounter()
  {
    return self::$constructed;
  }
}