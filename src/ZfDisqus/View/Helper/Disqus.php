<?php
/**
 * This file is part of the ZfDisqus package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

namespace ZfDisqus\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class Disqus extends AbstractHelper
{
    /**
     * Disqus forum shortname.
     *
     * @var string
     */
    protected $shortName;

    /**
     * Whether to append JS code to the InlineScript container.
     *
     * @var bool
     */
    protected $useInlineScriptContainer = true;

    /**
     * @var Disqus\WidgetManager
     */
    protected $widgets;

    /**
     * @param string $shortName
     */
    public function __construct($shortName = null)
    {
        if ($shortName !== null) {
            $this->setShortName($shortName);
        }
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     * @return self
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
        return $this;
    }

    public function getUseInlineScriptContainer()
    {
        return $this->useInlineScriptContainer;
    }

    public function setUseInlineScriptContainer($flag)
    {
        $this->useInlineScriptContainer = (bool) $flag;
        return $this;
    }

    /**
     * Set manager for retrieving widgets.
     *
     * @param Disqus\WidgetManager $widgets
     * @return self
     */
    public function setWidgetManager(Disqus\WidgetManager $widgets)
    {
        $renderer = $this->getView();
        if ($renderer) {
            $widgets->setRenderer($renderer);
        }
        $this->widgets = $widgets;

        return $this;
    }

    /**
     * Retrieve plugin loader for widgets.
     *
     * Lazy-loads an instance of Disqus\WidgetManager if none currently
     * registered.
     *
     * @return Disqus\WidgetManager
     */
    public function getWidgetManager()
    {
        if (null === $this->widgets) {
            $this->setWidgetManager(new Disqus\WidgetManager());
        }

        return $this->widgets;
    }

    /**
     *
     * @param string $name
     * @return Disqus\AbstractWidget
     * @throws Exception\RuntimeException
     */
    protected function findWidget($name)
    {
        $widgets = $this->getPluginManager();

        if (!$widgets->has($name)) {
            throw new Exception\RuntimeException(sprintf(
                'Failed to find widget for %s',
                $name
            ));
        }

        return $widgets->get($name);
    }

    /**
     * Overload method access; proxies calls to appropriate Disqus widget
     * and returns HTML output.
     *
     * @param  string $method
     * @param  array  $args
     * @throws Exception\BadMethodCallException
     * @return string
     */
    public function __call($method, $args)
    {
        if ($this->shortName === null) {
            throw new Exception\RuntimeException('Disqus short name must be provided');
        }

        $widget = $this->findWidget($method);

        $html = '';

        $config = array_shift($args) | array();
        $config['shortname'] = $this->shortName;
        $configScript = $widget->renderConfig($config);

        if ($this->useInlineScriptContainer) {
            $this->getView()->inlineScript()->appendScript($configScript);
        } else {
            $html .=
                '<script type="text/javascript">
                ' . $configScript . '
                </script>'
                . "\n\n";
        }

        $options = array_shift($args) | array();
        $html .= $widget->render($options);

        return $html;
    }


}
