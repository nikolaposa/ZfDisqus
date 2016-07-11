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

use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class Module implements ViewHelperProviderInterface
{
    public function getViewHelperConfig() : array
    {
        return require dirname(__DIR__) . '/config/view_helper.config.php';
    }
}
