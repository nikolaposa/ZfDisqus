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

namespace ZfDisqusTest\Util;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

final class ServiceManagerFactory
{
    /**
     * @var array
     */
    protected static $config;

    /**
     * @param array $config
     */
    public static function setConfig(array $config)
    {
        self::$config = $config;
    }

    /**
     * Builds a new service manager
     *
     * @return ServiceManager
     */
    public static function getServiceManager() : ServiceManager
    {
        $serviceManager = new ServiceManager(
            new ServiceManagerConfig(self::$config['service_manager'] ?? [])
        );

        $serviceManager->setService('ApplicationConfig', self::$config);

        $serviceManager->get('ModuleManager')->loadModules();

        return $serviceManager;
    }
}
