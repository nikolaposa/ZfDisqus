<?php
/**
 * This file is part of the ZfDisqus package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

namespace ZfDisqus;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ViewHelperProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'disqus' => function($sm) {
                    $locator = $sm->getServiceLocator();
                    $config = $locator->get('Config');

                    if (!isset($config['disqus']['shortname'])) {
                        throw new \Zend\ServiceManager\Exception\InvalidArgumentException(
                            'Disqus "shortname" must be set through the
                            \'disqus\' -> \'shortname\' configuration option'
                        );
                    }

                    return new View\Helper\Disqus($config['disqus']['shortname']);
                }
            )
        );
    }
}
