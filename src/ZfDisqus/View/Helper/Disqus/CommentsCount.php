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
 * Renders comments count link.
 * 
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class CommentsCount extends AbstractWidget
{
    protected function getScriptName()
    {
        return 'count.js';
    }

    public function render(array $options = array())
    {
        $urlOptions = array_merge(
            array('name' => null, 'params' => array(), 'options' => array(), 'reuseMatchedParams' => false),
            isset($options['url']) ? $options['url'] : array()
        );
        $urlOptions['options']['fragment'] = 'disqus_thread';

        $attribs = array();
        if (array_key_exists('identifier', $options)) {
            $attribs['data-disqus-identifier'] = $options['identifier'];
        }

        $label = isset($options['label']) ? $options['label'] : '';

        return '<a href="' . $this->getView()->url($urlOptions['name'], $urlOptions['params'], $urlOptions['options'], $urlOptions['reuseMatchedParams']) . '" '
            . $this->htmlAttribs($attribs) . '>'
            . $label
            . '</a>';
    }
}
