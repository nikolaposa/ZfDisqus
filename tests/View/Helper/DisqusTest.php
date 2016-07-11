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
use ZfDisqus\View\Helper\Disqus;
use DisqusHelper\Disqus as DisqusHelper;
use Zend\View\Exception\RuntimeException;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class DisqusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Disqus
     */
    protected $disqus;

    protected function setUp()
    {
        $this->disqus = new Disqus(DisqusHelper::create('test'));
    }

    public function testGettingShortName()
    {
        $this->assertEquals('test', $this->disqus->getShortName());
    }

    public function testSettingConfiguration()
    {
        $this->disqus->configure([
            'identifier' => 'article1',
            'title' => 'My article',
        ]);

        $html = (string) $this->disqus;

        $this->assertContains('article1', $html);
        $this->assertContains('My article', $html);
    }

    public function testWidgetInvokation()
    {
        $html = $this->disqus->thread();

        $this->assertInternalType('string', $html);
        $this->assertNotEmpty($html);
    }

    public function testDisqusHelperExceptionWrappedIntoZfViewException()
    {
        $this->setExpectedException(RuntimeException::class);

        $this->disqus->undefined();
    }
}
