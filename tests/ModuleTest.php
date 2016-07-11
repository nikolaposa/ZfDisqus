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

namespace ZfDisqus\Tests;

use PHPUnit_Framework_TestCase;
use ZfDisqus\Module;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    public function testGetViewHelperConfig()
    {
        $module = new Module();

        $viewHelperConfig = $module->getViewHelperConfig();

        $this->assertSame(
            @include 'config/view_helper.config.php',
            $viewHelperConfig,
            'View helper configuration could not be read'
        );
    }
}