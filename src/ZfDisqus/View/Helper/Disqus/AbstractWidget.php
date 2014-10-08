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

use Zend\View\Helper\AbstractHtmlElement;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
abstract class AbstractWidget extends AbstractHtmlElement implements WidgetInterface
{
    /**
     * @return string
     */
    abstract protected function getScriptName();

    public function renderScript(array $config)
    {
        $script = '';

        foreach ($config as $key => $value) {
            if (is_string($value)) {
                $value = addslashes((string)$value);
                $value = "'$value'";
            }
            $script .= "var disqus_$key = $value;\n";
        }

        $script .= '
        (function() {
            var s = document.createElement("script");
            s.type = "text/javascript";
            s.async = true;
            s.src = "//" + disqus_shortname + ".disqus.com/' . $this->getScriptName() . '";
            (document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(s);
        })();';

        return $script;;
    }
}
