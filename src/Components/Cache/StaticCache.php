<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 03/11/14
 */

namespace Kozz\Components\Cache;


use Closure;
use Doctrine\Common\Cache\ArrayCache;
use MS\Cache\Repository\CacheRepositoryInterface;

/**
 * Class StaticCache
 *
 * @package MS\Cache
 */
class StaticCache
{

  /**
   * @var ArrayCache
   */
  protected static $cache;

  /**
   * @param $id
   *
   * @return mixed
   */
  public static function get($id)
  {
    return self::getCache()->fetch($id);
  }

  /**
   * @param CacheRepositoryInterface $repository
   *
   * @return mixed
   */
  public static function loadRepository(CacheRepositoryInterface $repository)
  {
    return self::getOrInit(get_class($repository), function () use ($repository) {
      return $repository->getSingleton();
    });
  }

  /**
   * @param $id
   * @param $data
   *
   * @return bool
   */
  public static function set($id, $data)
  {
    return self::getCache()->save($id, $data);
  }

  /**
   * @param $id
   *
   * @return bool
   */
  public static function has($id)
  {
    return self::getCache()->contains($id);
  }

  /**
   * @param          $id
   * @param callable $closure
   *
   * @return mixed
   */
  protected static function getOrInit($id, Closure $closure)
  {
    if (!self::has($id)) {
      self::set($id, $closure());
    }

    return self::get($id);
  }

  /**
   * @return ArrayCache
   */
  protected static function getCache()
  {
    if (null === self::$cache) {
      self::$cache = new ArrayCache;
    }

    return self::$cache;
  }
} 