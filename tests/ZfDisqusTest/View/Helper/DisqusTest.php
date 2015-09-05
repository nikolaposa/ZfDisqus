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

        $html .= ' ' . $disqus->init();

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
}
