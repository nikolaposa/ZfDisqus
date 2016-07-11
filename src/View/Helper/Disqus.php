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

namespace ZfDisqus\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;
use DisqusHelper\Disqus as DisqusHelper;
use DisqusHelper\Exception\Exception as DisqusHelperException;

/**
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
    private $config = [];

    /**
     * @param DisqusHelper $disqusHelper
     */
    public function __construct(DisqusHelper $disqusHelper)
    {
        $this->disqusHelper = $disqusHelper;
    }

    /**
     * Proxies all calls to DisqusHelper.
     *
     * @param  string $method
     * @param  array  $args
     * @throws Exception\RuntimeException
     * @return string
     */
    public function __call($method, $args) : string
    {
        $options = array_shift($args) ?: [];

        $config = array_shift($args) ?: [];

        try {
            return $this->disqusHelper->$method($options, $config);
        } catch (DisqusHelperException $ex) {
            throw new Exception\RuntimeException($ex->getMessage());
        }
    }

    public function __invoke(array $config = []) : Disqus
    {
        $this->config = $config;
        return $this;
    }

    public function __toString() : string
    {
        $disqusHelper = $this->disqusHelper;
        return $disqusHelper($this->config);
    }
}
