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

/**
 * @group  ZfDisqus
 * @group  ZfDisqus_Widget
 *
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class ThreadTest extends AbstractTest
{
    protected $widgetName = 'ZfDisqus\View\Helper\Disqus\Thread';

    public function testRendering()
    {
        $html = $this->widget->render();

        $this->assertContains('id="disqus_thread"', $html);
    }
}
