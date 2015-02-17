Static Cache
================

[![Build Status](https://travis-ci.org/urakozz/php-static-cache.svg?branch=master)](https://travis-ci.org/urakozz/php-static-cache)
[![Coverage Status](https://coveralls.io/repos/urakozz/php-static-cache/badge.png)](https://coveralls.io/r/urakozz/php-static-cache)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/urakozz/php-static-cache/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/urakozz/php-static-cache/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/kozz/static-cache/v/stable.svg)](https://packagist.org/packages/kozz/static-cache)
[![Latest Unstable Version](https://poser.pugx.org/kozz/static-cache/v/unstable.svg)](https://packagist.org/packages/kozz/static-cache)
[![License](http://img.shields.io/packagist/l/kozz/static-cache.svg)](https://packagist.org/packages/kozz/static-cache)

Static Cache with Repositories

### About

You can use ```StaticCache``` as simple cache tool that allows you access cached data from 
every place of your application during runtime.

It doesn't stores data im memcached or some other data storage, 
that's just static implementation of Doctrine's ```ArrayCache```

The most powerful idea of this library is ```Repositories```

### Repositories

Repository allows you initialize some heavy library once and than it's instance with
simple Object-Oriented Style

E.g.:
Assume are using Symfony Validator several times during the runtime. 
That's bad idea initialize it every time in different places of the application so you can
easyly create SymfonyValidator Repository:

```php
//SymfonyValidator.php

class SymfonyValidator implements CacheRepositoryInterface
{

  public funcnction getSingleton()
  {
    return Validation::createValidatorBuilder()
      ->enableAnnotationMapping(new CachedReader(new AnnotationReader(), new ArrayCache()))
      ->setMetadataCache(new DoctrineCache(new ArrayCache()))
      ->getValidator();
  }
}

```

//SomeFile.php
use Kozz\Components\Cache\StaticCache

$validator = StaticCache::loadRepository(new SymfonyValidator());
//Validator initialized and saved in cache

//SomeOtherFile.php
use Kozz\Components\Cache\StaticCache

$validator = StaticCache::loadRepository(new SymfonyValidator());
//Now validator just loaded from cache

```

### Reference

Methods

```get($id)``` - get

```set($id, $data)``` - set

```has($id)``` - check

```loadRepository(CacheRepositoryInterface $repository)``` - load Repository
