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

use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\ServiceManager;
use ZfDisqus\Exception\DisqusConfigurationNotProvidedException;
use ZfDisqus\Tests\ServiceManagerFactory;
use ZfDisqus\View\Helper\Disqus as DisqusHelper;
use ZfDisqus\View\Helper\DisqusFactory;

class DisqusFactoryTest extends TestCase
{
    /**
     * @var DisqusFactory
     */
    protected $factory;

    protected function setUp()
    {
        $this->factory = new DisqusFactory();
    }

    /**
     * @test
     */
    public function it_creates_view_helper()
    {
        $container = new ServiceManager([
            'services' => [
                'config' => [
                    'disqus' => [
                        'shortname' => 'test',
                    ],
                ],
            ],
        ]);

        $this->assertInstanceOf(DisqusHelper::class, $this->factory->__invoke($container));
    }

    /**
     * @test
     */
    public function it_raises_exception_if_config_not_provided()
    {
        $container = new ServiceManager([
            'services' => [
                'config' => [
                    'disqus' => [],
                ],
            ],
        ]);

        try {
            $this->factory->__invoke($container);

            $this->fail('Exception should have been raised');
        } catch (DisqusConfigurationNotProvidedException $ex) {
            $this->assertSame('Disqus shortname must be provided through the `disqus` -> `shortname` configuration option', $ex->getMessage());
        }
    }

    /**
     * @test
     */
    public function it_is_registered_as_app_view_helper_factory()
    {
        $serviceManager = ServiceManagerFactory::getServiceManager();

        $viewHelper = $serviceManager->get('ViewHelperManager');

        $this->assertTrue($viewHelper->has('Disqus'));
        $this->assertTrue($viewHelper->has('disqus'));
        $disqusHelper = $viewHelper->get('Disqus');
        $this->assertSame('test', $disqusHelper->getShortname());
    }
}
