<?php
/**
 * @author Yury Kozyrev [https://github.com/urakozz]
 */

namespace Kozz\Components\Cache\Repository;


use Symfony\Component\DependencyInjection\ContainerBuilder;

class DiRepository implements CacheRepositoryInterface{

  public function getSingleton()
  {
    return new ContainerBuilder();
  }
}