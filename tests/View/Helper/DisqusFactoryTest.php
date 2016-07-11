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

namespace ZfDisqus\Tests\View\Helper;

use PHPUnit_Framework_TestCase;
use ZfDisqus\View\Helper\Service\DisqusFactory;
use ZfDisqus\View\Helper\Disqus;
use ZfDisqus\Tests\Util\ServiceManagerFactory;
use Zend\View\HelperPluginManager;
use ZfDisqus\Exception\DisqusConfigurationNotProvidedException;

class DisqusFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DisqusFactory
     */
    protected $disqusFactory;

    protected function setUp()
    {
        $this->disqusFactory = new DisqusFactory();
    }

    public function testServiceManagerV3Creation()
    {
        $factory = $this->disqusFactory;

        $disqus = $factory(ServiceManagerFactory::getServiceManager(), 'disqus');

        $this->assertInstanceOf(Disqus::class, $disqus);
        $this->assertEquals('test', $disqus->getShortname());
    }

    public function testServiceManagerV2Creation()
    {
        $disqus = $this->disqusFactory->createService(ServiceManagerFactory::getServiceManager());

        $this->assertInstanceOf(Disqus::class, $disqus);
        $this->assertEquals('test', $disqus->getShortname());
    }

    public function testExceptionIsRaisedIfDisqusConfigurationIsNotProvided()
    {
        $this->setExpectedException(DisqusConfigurationNotProvidedException::class);

        $this->disqusFactory->createService(ServiceManagerFactory::getServiceManager([
            'modules' => [
                'ZfDisqus',
            ],
            'module_listener_options' => [
                'config_glob_paths' => [],
                'module_paths' => [
                    'src',
                ],
            ],
        ]));
    }

    public function testConfiguringDisqusInstanceAfterCreation()
    {
        $disqus = $this->disqusFactory->createService(ServiceManagerFactory::getServiceManager([
            'modules' => [
                'ZfDisqus',
            ],
            'module_listener_options' => [
                'extra_config' => [
                    'disqus' => [
                        'shortname' => 'test',
                        'lang' => 'en_US',
                    ],
                ],
                'module_paths' => [
                    'src',
                ],
            ],
        ]));

        $html = (string) $disqus;

        $this->assertContains('lang', $html);
        $this->assertContains('en_US', $html);
    }
}