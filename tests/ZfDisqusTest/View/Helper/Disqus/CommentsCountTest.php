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

use Zend\View\Helper\Url as UrlHelper;

/**
 * @group  ZfDisqus
 * @group  ZfDisqus_Widget
 *
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class CommentsCountTest extends AbstractTest
{
    protected $widgetName = 'ZfDisqus\View\Helper\Disqus\CommentsCount';

    /**
     * @var UrlHelper
     */
    protected $urlHelper;

    protected function setUp()
    {
        parent::setUp();

        $this->urlHelper = $this->getMock('\\Zend\\View\\Helper\\Url');
        $this->view->getHelperPluginManager()->setService('url', $this->urlHelper);
    }

    protected function assertLink($html, $url, $label = null, array $attributes = array())
    {
        $this->assertStringStartsWith('<a', $html);
        $this->assertStringEndsWith('</a>', $html);
        $this->assertRegexp('|href\s?=\s?"' . preg_quote($url, '|') . '"|', $html);

        if ($label) {
            $this->assertContains(">$label<", $html);
        }

        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $this->assertRegexp('|' . preg_quote($key) . '\s?=\s?"' . preg_quote($value, '|') . '"|', $html);
            }
        }
    }

    public function testRenderingUrlWithFragment()
    {
        $url = '/test#disqus_thread';

        $this->urlHelper->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue($url));

        $html = $this->widget->render();

        $this->assertLink($html, $url);
    }

    public function testRenderingLinkWithCustomUrlOptions()
    {
        $options = array(
            'url' => array(
                'name' => 'home',
                'params' => array('foo' => 'bar'),
                'options' => array('query' => array('p' => 1)),
                'reuseMatchedParams' => true
            )
        );
        $options['url']['options']['fragment'] = 'disqus_thread';

        $this->urlHelper->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo($options['url']['name']),
                $this->equalTo($options['url']['params']),
                $this->equalTo($options['url']['options']),
                $this->equalTo($options['url']['reuseMatchedParams'])
            );

        $this->widget->render($options);
    }

    public function testRenderingLinkWithIdentifierAttribute()
    {
        $url = '/test#disqus_thread';

        $this->urlHelper->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue($url));

        $html = $this->widget->render(array('identifier' => 'test'));

        $this->assertLink($html, $url, null, array('identifier' => 'test'));
    }

    public function testRenderingLinkWithLabel()
    {
        $url = '/test#disqus_thread';

        $this->urlHelper->expects($this->once())
            ->method('__invoke')
            ->will($this->returnValue($url));

        $html = $this->widget->render(array('label' => 'Test'));

        $this->assertLink($html, $url, 'Test');
    }
}
