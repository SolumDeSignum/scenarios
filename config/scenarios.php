<?php

declare(strict_types=1);

return [
    'features' => [
        'setMethodFromUrlSegment' => false,
        'setMethodFromController' => true,
    ],
    'methods' => [
        'pattern' => '/create|store|update|destroy/im'
    ]
];
