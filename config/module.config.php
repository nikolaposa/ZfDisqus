<?php

return [
    'disqus' => [
        'shortname' => 'your_disqus_shortname',
    ],
    'view_helpers' => [
        'factories' => [
            'Disqus' => \ZfDisqus\View\Helper\DisqusFactory::class,
            'disqus' => \ZfDisqus\View\Helper\DisqusFactory::class,
        ],
    ],
];
