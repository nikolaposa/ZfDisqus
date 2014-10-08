<?php
/**
 * This file is part of the ZfDisqus package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

namespace ZfDisqus\View\Helper\Disqus;

use Zend\View\Exception;
use Zend\View\HelperPluginManager;

/**
 * Plugin manager implementation for Disqus widgets
 *
 * Enforces that retrieved widgets  are instances of Disqus\WidgetInterface.
 * Additionally, it registers a number of default widgets.
 */
class WidgetManager extends HelperPluginManager
{
    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = array(
        'thread'        => 'ZfDisqus\View\Helper\Disqus\Thread',
        'commentscount' => 'ZfDisqus\View\Helper\Disqus\CommentsCount',
    );

    /**
     * Validate the plugin
     *
     * @param  mixed $plugin
     * @return void
     * @throws Exception\InvalidArgumentException if invalid
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractWidget) {
            // we're okay
            return;
        }

        throw new Exception\InvalidArgumentException(sprintf(
            'Plugin of type %s is invalid; must extend %s\AbstractWidget',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}
