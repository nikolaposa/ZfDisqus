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

use PHPUnit\Framework\TestCase;
use ZfDisqus\Module;

class ModuleTest extends TestCase
{
    /**
     * @var Module
     */
    protected $module;

    protected function setUp()
    {
        $this->module = new Module();
    }

    /**
     * @test
     */
    public function it_provides_config()
    {
        $config = include __DIR__ . '/../config/module.config.php';

        $this->assertSame($config, $this->module->getConfig());
    }
}
