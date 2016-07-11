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

namespace ZfDisqusTest\View\Helper;

use PHPUnit_Framework_TestCase;
use ZfDisqus\View\Helper\Disqus;
use DisqusHelper\Disqus as DisqusHelper;
use Zend\View\Renderer\PhpRenderer as View;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class DisqusTest extends PHPUnit_Framework_TestCase
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
        $disqus = new Disqus(new DisqusHelper('blog', [
            'title' => 'My article',
            'identifier' => 'article1'
        ]));

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

    public function testInvocationOnViewInstance()
    {
        $view = new View();

        $view->getHelperPluginManager()->setService('disqus', new Disqus(new DisqusHelper('foobar')));

        $html = $view->disqus()->thread();

        $html .= ' ' . $view->disqus(['shortname' => 'test123']);

        $this->assertContains('<script', $html);
        $this->assertContains('shortname', $html);
        $this->assertContains('test123', $html);
        $this->assertContains('</script>', $html);
    }
}
