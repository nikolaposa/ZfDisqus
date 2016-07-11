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

use ZfDisqusTest\Util\ServiceManagerFactory;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/TestConfig.php')) {
    $config = include __DIR__ . '/TestConfig.php';
} else {
    $config = include __DIR__ . '/TestConfig.php.dist';
}

ServiceManagerFactory::setConfig($config);
ServiceManagerFactory::getServiceManager();
