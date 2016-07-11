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

error_reporting(E_ALL | E_STRICT);

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

$testConfig = file_exists('TestConfig.php') ? require 'TestConfig.php' : require 'TestConfig.php.dist';

ZfDisqus\Tests\Util\ServiceManagerFactory::setConfig($testConfig);
