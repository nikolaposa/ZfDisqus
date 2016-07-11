<?php
/**
 * This file is part of the ZfDisqus Module package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

declare(strict_types=1);

namespace ZfDisqus\Tests\Util;

use Zend\ServiceManager\ServiceManager;
use Zend\Test\Util\ModuleLoader;

final class ServiceManagerFactory
{
    /**
     * @var array
     */
    protected static $config;

    private function __construct()
    {
    }

    public static function setConfig(array $config)
    {
        self::$config = $config;
    }

    public static function getServiceManager(array $config = null) : ServiceManager
    {
        $moduleLoader = new ModuleLoader($config ?: self::$config);

        return $moduleLoader->getServiceManager();
    }
}
