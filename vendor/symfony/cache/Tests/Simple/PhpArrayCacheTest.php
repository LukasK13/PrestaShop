<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MolliePrefix\Symfony\Component\Cache\Tests\Simple;

use MolliePrefix\Symfony\Component\Cache\Simple\NullCache;
use MolliePrefix\Symfony\Component\Cache\Simple\PhpArrayCache;
use MolliePrefix\Symfony\Component\Cache\Tests\Adapter\FilesystemAdapterTest;
/**
 * @group time-sensitive
 */
class PhpArrayCacheTest extends \MolliePrefix\Symfony\Component\Cache\Tests\Simple\CacheTestCase
{
    protected $skippedTests = ['testBasicUsageWithLongKey' => 'PhpArrayCache does no writes', 'testDelete' => 'PhpArrayCache does no writes', 'testDeleteMultiple' => 'PhpArrayCache does no writes', 'testDeleteMultipleGenerator' => 'PhpArrayCache does no writes', 'testSetTtl' => 'PhpArrayCache does no expiration', 'testSetMultipleTtl' => 'PhpArrayCache does no expiration', 'testSetExpiredTtl' => 'PhpArrayCache does no expiration', 'testSetMultipleExpiredTtl' => 'PhpArrayCache does no expiration', 'testGetInvalidKeys' => 'PhpArrayCache does no validation', 'testGetMultipleInvalidKeys' => 'PhpArrayCache does no validation', 'testSetInvalidKeys' => 'PhpArrayCache does no validation', 'testDeleteInvalidKeys' => 'PhpArrayCache does no validation', 'testDeleteMultipleInvalidKeys' => 'PhpArrayCache does no validation', 'testSetInvalidTtl' => 'PhpArrayCache does no validation', 'testSetMultipleInvalidKeys' => 'PhpArrayCache does no validation', 'testSetMultipleInvalidTtl' => 'PhpArrayCache does no validation', 'testHasInvalidKeys' => 'PhpArrayCache does no validation', 'testSetValidData' => 'PhpArrayCache does no validation', 'testDefaultLifeTime' => 'PhpArrayCache does not allow configuring a default lifetime.', 'testPrune' => 'PhpArrayCache just proxies'];
    protected static $file;
    public static function setUpBeforeClass()
    {
        self::$file = \sys_get_temp_dir() . '/symfony-cache/php-array-adapter-test.php';
    }
    protected function tearDown()
    {
        $this->createSimpleCache()->clear();
        if (\file_exists(\sys_get_temp_dir() . '/symfony-cache')) {
            \MolliePrefix\Symfony\Component\Cache\Tests\Adapter\FilesystemAdapterTest::rmdir(\sys_get_temp_dir() . '/symfony-cache');
        }
    }
    public function createSimpleCache()
    {
        return new \MolliePrefix\Symfony\Component\Cache\Tests\Simple\PhpArrayCacheWrapper(self::$file, new \MolliePrefix\Symfony\Component\Cache\Simple\NullCache());
    }
    public function testStore()
    {
        $arrayWithRefs = [];
        $arrayWithRefs[0] = 123;
        $arrayWithRefs[1] =& $arrayWithRefs[0];
        $object = (object) ['foo' => 'bar', 'foo2' => 'bar2'];
        $expected = ['null' => null, 'serializedString' => \serialize($object), 'arrayWithRefs' => $arrayWithRefs, 'object' => $object, 'arrayWithObject' => ['bar' => $object]];
        $cache = new \MolliePrefix\Symfony\Component\Cache\Simple\PhpArrayCache(self::$file, new \MolliePrefix\Symfony\Component\Cache\Simple\NullCache());
        $cache->warmUp($expected);
        foreach ($expected as $key => $value) {
            $this->assertSame(\serialize($value), \serialize($cache->get($key)), 'Warm up should create a PHP file that OPCache can load in memory');
        }
    }
    public function testStoredFile()
    {
        $expected = ['integer' => 42, 'float' => 42.42, 'boolean' => \true, 'array_simple' => ['foo', 'bar'], 'array_associative' => ['foo' => 'bar', 'foo2' => 'bar2']];
        $cache = new \MolliePrefix\Symfony\Component\Cache\Simple\PhpArrayCache(self::$file, new \MolliePrefix\Symfony\Component\Cache\Simple\NullCache());
        $cache->warmUp($expected);
        $values = eval(\substr(\file_get_contents(self::$file), 6));
        $this->assertSame($expected, $values, 'Warm up should create a PHP file that OPCache can load in memory');
    }
}
class PhpArrayCacheWrapper extends \MolliePrefix\Symfony\Component\Cache\Simple\PhpArrayCache
{
    public function set($key, $value, $ttl = null)
    {
        \call_user_func(\Closure::bind(function () use($key, $value) {
            $this->values[$key] = $value;
            $this->warmUp($this->values);
            $this->values = eval(\substr(\file_get_contents($this->file), 6));
        }, $this, \MolliePrefix\Symfony\Component\Cache\Simple\PhpArrayCache::class));
        return \true;
    }
    public function setMultiple($values, $ttl = null)
    {
        if (!\is_array($values) && !$values instanceof \Traversable) {
            return parent::setMultiple($values, $ttl);
        }
        \call_user_func(\Closure::bind(function () use($values) {
            foreach ($values as $key => $value) {
                $this->values[$key] = $value;
            }
            $this->warmUp($this->values);
            $this->values = eval(\substr(\file_get_contents($this->file), 6));
        }, $this, \MolliePrefix\Symfony\Component\Cache\Simple\PhpArrayCache::class));
        return \true;
    }
}
