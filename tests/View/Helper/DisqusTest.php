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

use DisqusHelper\Disqus as DisqusHelper;
use PHPUnit\Framework\TestCase;
use Zend\View\Exception\RuntimeException;
use ZfDisqus\View\Helper\Disqus;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class DisqusTest extends TestCase
{
    /**
     * @var Disqus
     */
    protected $disqus;

    protected function setUp()
    {
        $this->disqus = new Disqus(DisqusHelper::create('test'));
    }

    /**
     * @test
     */
    public function it_provides_short_name()
    {
        $this->assertSame('test', $this->disqus->getShortName());
    }

    /**
     * @test
     */
    public function it_sets_configuration()
    {
        $this->disqus->configure([
            'identifier' => 'article1',
            'title' => 'My article',
        ]);

        $html = (string) $this->disqus;

        $this->assertContains('article1', $html);
        $this->assertContains('My article', $html);
    }

    /**
     * @test
     */
    public function it_invokes_widget()
    {
        $html = $this->disqus->thread();

        $this->assertInternalType('string', $html);
        $this->assertNotEmpty($html);
    }

    /**
     * @test
     */
    public function it_wraps_disqus_helper_exceptions_into_zf_view_exceptions()
    {
        try {
            $this->disqus->undefined();

            $this->fail('Exception should have been raised');
        } catch (\Exception $ex) {
            $this->assertInstanceOf(RuntimeException::class, $ex);
        }
    }
}
