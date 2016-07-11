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

namespace ZfDisqus\View\Helper\Service;

use Zend\ServiceManager\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfDisqus\View\Helper\Disqus;
use DisqusHelper\Disqus as DisqusHelper;
use ZfDisqus\Exception\DisqusConfigurationNotProvidedException;

final class DisqusFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(ContainerInterface $container, $name, array $options = null) : Disqus
    {
        // test if we are using Zend\ServiceManager v2 or v3
        if (! method_exists($container, 'configure')) {
            $container = $container->getServiceLocator();
        }

        $config = $container->get('Config');

        return new Disqus($this->createDisqusHelper($config['disqus'] ?? []));
    }

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator, $rName = null, $cName = null) : Disqus
    {
        return $this($serviceLocator, $cName);
    }

    private function createDisqusHelper(array $config) : DisqusHelper
    {
        if (!isset($config['shortname'])) {
            throw new DisqusConfigurationNotProvidedException('Disqus shortname must be provided through the `disqus` -> `shortname` configuration option');
        }

        $shortName = $config['shortname'];
        unset($config['shortname']);

        $disqusHelper = DisqusHelper::create($shortName);

        if (!empty($config)) {
            $disqusHelper->configure($config);
        }

        return $disqusHelper;
    }
}