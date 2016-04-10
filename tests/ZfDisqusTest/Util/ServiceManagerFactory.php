<?php
/**
 * This file is part of the ZfDisqus package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

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
    public static function getServiceManager()
    {
        $serviceManager = new ServiceManager(
            new ServiceManagerConfig(
                isset(self::$config['service_manager']) ? self::$config['service_manager'] : array()
            )
        );

        $serviceManager->setService('ApplicationConfig', self::$config);

        $serviceManager->get('ModuleManager')->loadModules();

        return $serviceManager;
    }
}
