<?php
/**
 * @author ykmship@yandex-team.ru
 * Date: 03/11/14
 */

namespace Kozz\Components\Cache;


use Closure;
use Doctrine\Common\Cache\ArrayCache;
use Kozz\Components\Cache\Repository\CacheRepositoryInterface;
use Kozz\Components\Cache\Repository\DiRepository;
use PhpOption\Option;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;

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

  public static function loadInjection($name, Definition $definition)
  {
    $di = self::loadRepository(new DiRepository());
    return Option::fromValue($di->get($name, ContainerInterface::NULL_ON_INVALID_REFERENCE))->getOrCall(function()use($di,$definition, $name){
      $di->setDefinition($name, $definition);
      return $di->get($name);
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