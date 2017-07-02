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

namespace ZfDisqus\View\Helper;

use DisqusHelper\Disqus as DisqusHelper;
use Interop\Container\ContainerInterface;
use ZfDisqus\Exception\DisqusConfigurationNotProvidedException;

final class DisqusFactory
{
    public function __invoke(ContainerInterface $container) : Disqus
    {
        $config = $container->get('config');

        return new Disqus($this->createDisqusHelper($config['disqus'] ?? []));
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
