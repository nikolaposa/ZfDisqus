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
use ZfDisqus\View\Helper\Disqus;
use Zend\View\Renderer\PhpRenderer as View;

/**
 * @group  ZfDisqus
 *
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class DisqusTest extends PHPUnit_Framework_TestCase
{
    const SHORTNAME = 'foo_bar_baz';

    /**
     * @var Disqus
     */
    protected $helper;

    protected function setUp()
    {
        $this->helper = new Disqus(self::SHORTNAME);
        $this->view = new View();
        $this->helper->setView($this->view);
    }

    public function testSettingShortName()
    {
        $this->helper->setShortName('foobar');
        $this->assertEquals('foobar', $this->helper->getShortName());
    }

    public function testInlineScriptFlag()
    {
        $this->helper->setUseInlineScriptContainer(false);
        $this->assertFalse($this->helper->getUseInlineScriptContainer());
    }

    public function testWidgetManagerUsedByDefault()
    {
        $this->assertInstanceOf('ZfDisqus\View\Helper\Disqus\WidgetManager', $this->helper->getWidgetManager());
    }

    /**
     * @expectedException \Zend\View\Exception\RuntimeException
     */
    public function testInvokationFailsIfWidgetCantBeFound()
    {
        $this->helper->foobar(array('test'));
    }

    protected function assertWidgetCall($config, $options, $html = '')
    {
        $config = (array) $config;
        $options = (array) $options;

        $threadMock = $this->getMock('ZfDisqus\View\Helper\Disqus\Thread');
        $threadMock->expects($this->once())
            ->method('renderScript')
            ->with($this->equalTo($config))
            ->will($this->returnValue(current($config)));

        $renderMock = $threadMock->expects($this->once())->method('render')->with($this->equalTo($options));
        if ($html) {
            $renderMock->will($this->returnValue($html));
        }

        $this->helper->getWidgetManager()->setService('thread', $threadMock);

        return $this->helper->thread($config, $options);
    }

    public function testInvokingWidgetWithConfigAndRenderingOptions()
    {
        $config = array('shortname' => self::SHORTNAME, 'foo' => 'bar');
        $options = null;

        $this->assertWidgetCall($config, $options);
    }

    public function testInvokingWidgetRendersScriptIntoTheInlineScriptContainer()
    {
        $this->helper->setUseInlineScriptContainer(false);

        $html = $this->assertWidgetCall(array('shortname' => self::SHORTNAME), null, '<div id="test"></div>');

        $this->assertContains('<script', $html);
        $this->assertContains('</script>', $html);
        $this->assertContains('<div id="test"></div>', $html);
    }

    public function testInvokingWidgetRendersScriptAlongWithHtmlWhenUseInlineScriptFlagIsFalse()
    {
        $this->helper->setUseInlineScriptContainer(true);

        $html = $this->assertWidgetCall(array('shortname' => self::SHORTNAME), null, '<div id="test"></div>');

        $this->assertNotContains('<script', $html);
        $this->assertContains('<div id="test"></div>', $html);

        $inlineScript = (string) $this->helper->getView()->plugin('inlineScript');
        $this->assertContains('<script', $inlineScript);
        $this->assertContains(self::SHORTNAME, $inlineScript);
        $this->assertContains('</script>', $inlineScript);
    }

    public function testInvokingWidgetWithCustomShortName()
    {
        $config = array('shortname' => 'custom', 'foo' => 'bar');
        $options = null;

        $this->assertWidgetCall($config, $options);
    }
}
