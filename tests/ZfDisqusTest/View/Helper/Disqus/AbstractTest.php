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

    protected $view;

    protected function setUp()
    {
        $widgetName = $this->widgetName;
        $this->widget = new $widgetName();

        $this->view = new View();
        $this->widget->setView($this->view);
    }

    public function testRenderingScript()
    {
        $config = array(
            'shortname' => 'test',
            'foo' => 1,
        );

        $script = $this->widget->renderScript($config);

        foreach ($config as $key => $value) {
            if (is_string($value)) {
                $value = "'$value'";
            }
            $this->assertRegexp('/var disqus_' . $key . '\s?=\s?' . $value . '/', $script);
        }

        $reflection = new \ReflectionObject($this->widget);
        $method = $reflection->getMethod('getScriptName');
        $method->setAccessible(true);
        
        $this->assertContains($method->invoke($this->widget), $script);
    }
}
