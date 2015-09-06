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
use DisqusHelper\Disqus as DisqusHelper;
use DisqusHelper\Exception\Exception as DisqusHelperException;

/**
 * Wrapper around DisqusHelper.
 *
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
final class Disqus extends AbstractHelper
{
    /**
     * @var DisqusHelper
     */
    private $disqusHelper;

    /**
     * @var array
     */
    private static $plugins = array();

    /**
     * @param DisqusHelper $disqusHelper
     */
    public function __construct(DisqusHelper $disqusHelper)
    {
        $this->disqusHelper = $disqusHelper;

        self::$plugins = array(
            'pluginUrlBuilder'
        );
    }

    /**
     * Proxies all calls to DisqusHelper.
     *
     * @param  string $method
     * @param  array  $args
     * @throws Exception\RuntimeException
     * @return string
     */
    public function __call($method, $args)
    {
        if (($options = array_shift($args)) !== null) {
            if (is_array($options)) {
                foreach (self::$plugins as $plugin) {
                    $options = $this->$plugin($options);
                }

                $args[0] = $options;
            }
        } else {
            $options = array();
        }

        $config = array_shift($args) ?: array();

        try {
            return $this->disqusHelper->$method($options, $config);
        } catch (DisqusHelperException $ex) {
            throw new Exception\RuntimeException($ex->getMessage());
        }
    }

    /**
     * @see \DisqusHelper\Disqus::__invoke()
     */
    public function __invoke(array $config = array())
    {
        $disqusHelper = $this->disqusHelper;
        return $disqusHelper($config);
    }

    /**
     * @param array $options
     * @return void
     */
    protected function pluginUrlBuilder(array $options)
    {
        if (isset($options['url']) && is_array($options['url'])) {
            $urlOptions = array_merge(
                array('name' => null, 'params' => array(), 'options' => array(), 'reuseMatchedParams' => false),
                $options['url']
            );
            $options['url'] = $this->getView()->url($urlOptions['name'], $urlOptions['params'], $urlOptions['options'], $urlOptions['reuseMatchedParams']);
        }

        return $options;
    }
}
