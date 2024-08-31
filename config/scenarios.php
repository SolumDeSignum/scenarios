<?php

declare(strict_types=1);

return [
    'features' => [
        'set_method' => [
            'from' => [
                'controller' => true,
                'url_segment' => false,
            ],
            'exceptions' => [
                'controller' => true
            ],
        ],
    ],
    'methods' => [
        'pattern' => '/create|store|update|destroy/im',
    ],
];
