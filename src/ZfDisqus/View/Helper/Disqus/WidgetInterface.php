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

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
interface WidgetInterface
{
    /**
     * @param array $config
     * @return string
     */
    public function renderScript(array $config);

    /**
     * @param array $options OPTIONAL
     * @return string
     */
    public function render(array $options = array());
}
