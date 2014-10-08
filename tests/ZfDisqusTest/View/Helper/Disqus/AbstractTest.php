<?php
/**
 * This file is part of the ZfDisqus package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

namespace ZfDisqusTest\View\Helper\Disqus;

use PHPUnit_Framework_TestCase;
use ZfDisqus\View\Helper\Disqus\AbstractWidget as Widget;
use Zend\View\Renderer\PhpRenderer as View;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
abstract class AbstractTest extends PHPUnit_Framework_TestCase
{
    protected $widgetName;

    /**
     * @var Widget
     */
    protected $widget;

    /**
     * @var View
     */
    protected $view;

    protected function setUp()
    {
        $widgetName = $this->widgetName;
        $this->widget = new $widgetName();

        $this->view = new View();
        $this->widget->setView($this->view);
    }

    protected function assertConfig($config, $script)
    {
        foreach ($config as $key => $value) {
            if (is_string($value)) {
                $value = "'$value'";
            }
            $this->assertRegexp('/var disqus_' . $key . '\s?=\s?' . $value . '/', $script);
        }
    }

    public function testAddingScriptIntoTheInlineScriptContainer()
    {
        $this->widget->setUseInlineScriptContainer(true);

        $config = array(
            'shortname' => 'test',
            'foo' => 1,
        );

        $script = $this->widget->renderScript($config);

        $this->assertEquals('', $script);

        $inlineScript = (string) $this->widget->getView()->plugin('inlineScript');
        $this->assertContains('<script', $inlineScript);
        $this->assertContains('</script>', $inlineScript);
        $this->assertConfig($config, $inlineScript);
    }

    public function testRenderingScriptWhenUseInlineScriptFlagIsFalse()
    {
        $this->widget->setUseInlineScriptContainer(false);

        $config = array(
            'shortname' => 'test',
            'foo' => true,
        );

        $script = $this->widget->renderScript($config);

        $this->assertContains('<script', $script);
        $this->assertContains('</script>', $script);
        $this->assertConfig($config, $script);
    }

    public function testAppropriateJsFileLoaded()
    {
        $this->widget->setUseInlineScriptContainer(false);

        $script = $this->widget->renderScript(array());

        $reflection = new \ReflectionObject($this->widget);
        $method = $reflection->getMethod('getScriptName');
        $method->setAccessible(true);

        $this->assertContains($method->invoke($this->widget), $script);
    }

    public function testScriptRenderedOnlyOnce()
    {
        $this->widget->setUseInlineScriptContainer(false);

        $script = $this->widget->renderScript(array());
        $this->assertContains('<script', $script);
        $this->assertContains('</script>', $script);

        $this->assertEmpty($this->widget->renderScript(array()));
        $this->assertEmpty($this->widget->renderScript(array()));
    }
}
