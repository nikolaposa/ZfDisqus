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

namespace ZfDisqus;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use ZfDisqus\View\Helper\Disqus;
use DisqusHelper\Disqus as DisqusHelper;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ViewHelperProviderInterface
{
    public function getAutoloaderConfig() : array
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ]
        ];
    }

    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getViewHelperConfig() : array
    {
        return [
            'factories' => [
                'disqus' => function($pm) {
                    $serviceLocator = $pm->getServiceLocator();
                    $config = $serviceLocator->get('Config');

                    if (!isset($config['disqus']['shortname'])) {
                        throw new \Zend\ServiceManager\Exception\InvalidArgumentException(
                            'Disqus "shortname" must be provided through the \'disqus\' -> \'shortname\' configuration option'
                        );
                    }

                    return new Disqus(new DisqusHelper($config['disqus']['shortname'], $config['disqus']));
                }
            ]
        ];
    }
}
