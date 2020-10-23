<?php

declare(strict_types=1);

namespace PackageVersions;

/**
 * This class is generated by ocramius/package-versions, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 */
final class Versions
{
    public const ROOT_PACKAGE_NAME = 'marius/prefix';
    public const VERSIONS          = array (
  'humbug/php-scoper' => '0.11.4@6fcb3ce7dce5b96e17fac2af17e801741f387df5',
  'jetbrains/phpstorm-stubs' => 'v2019.1@9e309771f362e979ecfb429303ad7a402c657234',
  'nikic/php-parser' => 'v4.10.2@658f1be311a230e0907f5dfe0213742aff0596de',
  'ocramius/package-versions' => '1.4.2@44af6f3a2e2e04f2af46bcb302ad9600cba41c7d',
  'phpdocumentor/reflection-common' => '1.0.1@21bdeb5f65d7ebf9f43b1b25d404f87deab5bfb6',
  'phpdocumentor/reflection-docblock' => '4.3.4@da3fd972d6bafd628114f7e7e036f45944b62e9c',
  'phpdocumentor/type-resolver' => '0.4.0@9c977708995954784726e25d0cd1dddf4e65b0f7',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'roave/better-reflection' => '3.3.0@df78b556a7280c4145d4ed5edd2ca6a7e7e22716',
  'roave/signature' => '1.1.0@c4e8a59946bad694ab5682a76e7884a9157a8a2c',
  'symfony/console' => 'v4.4.14@90933b39c7b312fc3ceaa1ddeac7eb48cb953124',
  'symfony/filesystem' => 'v4.4.14@0d386979828c15d37ff936bf9bae2ecbfa36d7dc',
  'symfony/finder' => 'v4.4.14@5ef0f6c609c1a36f723880dfe78301199bc96868',
  'symfony/polyfill-ctype' => 'v1.18.1@1c302646f6efc070cd46856e600e5e0684d6b454',
  'symfony/polyfill-mbstring' => 'v1.18.1@a6977d63bf9a0ad4c65cd352709e230876f9904a',
  'symfony/polyfill-php73' => 'v1.18.1@fffa1a52a023e782cdcc221d781fe1ec8f87fcca',
  'symfony/polyfill-php80' => 'v1.18.1@d87d5766cbf48d72388a9f6b85f280c8ad51f981',
  'symfony/service-contracts' => 'v1.1.9@b776d18b303a39f56c63747bcb977ad4b27aca26',
  'webmozart/assert' => '1.9.1@bafc69caeb4d49c39fd0779086c03a3738cbb389',
  'marius/prefix' => 'dev-4.0.9-phpstan@dd673996009b9204d8aaa27b5ca9045600457c94',
);

    private function __construct()
    {
    }

    /**
     * @throws \OutOfBoundsException If a version cannot be located.
     */
    public static function getVersion(string $packageName) : string
    {
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new \OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
