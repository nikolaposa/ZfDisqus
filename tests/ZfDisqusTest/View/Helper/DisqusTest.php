<?php
/**
 * This file is part of the ZfDisqus package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

namespace ZfDisqusTest\View\Helper;

use ZfDisqus\View\Helper\Disqus;
use DisqusHelper\Disqus as DisqusHelper;
use Zend\View\Renderer\PhpRenderer as View;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class DisqusTest extends \PHPUnit_Framework_TestCase
{
    public function testWidgetRendering()
    {
        $disqus = new Disqus(new DisqusHelper('foobar'));

        $html = $disqus->thread();
        $this->assertInternalType('string', $html);
        $this->assertNotEmpty($html);
    }

    public function testInitRendersConfig()
    {
        $disqus = new Disqus(new DisqusHelper('blog', array(
            'title' => 'My article',
            'identifier' => 'article1'
        )));

        $html = $disqus->thread();

        $html .= ' ' . $disqus();

        $this->assertContains('<script', $html);
        $this->assertContains('shortname', $html);
        $this->assertContains('blog', $html);
        $this->assertContains('title', $html);
        $this->assertContains('My article', $html);
        $this->assertContains('identifier', $html);
        $this->assertContains('article1', $html);
        $this->assertContains('</script>', $html);
    }

    /**
     * @expectedException \Zend\View\Exception\RuntimeException
     */
    public function testDisqusHelperExceptionWrappedIntoZfViewException()
    {
        $disqus = new Disqus(new DisqusHelper('foobar'));
        $disqus->undefined();
    }

    public function testUrlArrayParameterIsProperlyBuiltToString()
    {
        $disqus = new Disqus(new DisqusHelper('foobar'));
        $view = new View();

        $disqus->setView($view);

        $urlHelper = $this->getMock('Zend\View\Helper\Url');
        $view->getHelperPluginManager()->setService('url', $urlHelper);

        $options = array(
            'url' => array(
                'name' => 'viewPost',
                'params' => array('id' => 1),
                'options' => array(),
                'reuseMatchedParams' => true
            )
        );

        $urlHelper->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo($options['url']['name']),
                $this->equalTo($options['url']['params']),
                $this->equalTo($options['url']['options']),
                $this->equalTo($options['url']['reuseMatchedParams'])
            )->will($this->returnValue('/blog/article1'));

        $html = $disqus->commentsCount($options);

        $this->assertContains('<a', $html);
        $this->assertContains('href', $html);
        $this->assertContains('/blog/article1', $html);
    }

    public function testInvocationOnViewInstance()
    {
        $view = new View();

        $view->getHelperPluginManager()->setService('disqus', new Disqus(new DisqusHelper('foobar')));

        $html = $view->disqus()->thread();

        $html .= ' ' . $view->disqus(array('shortname' => 'test123'));

        $this->assertContains('<script', $html);
        $this->assertContains('shortname', $html);
        $this->assertContains('test123', $html);
        $this->assertContains('</script>', $html);
    }
}
