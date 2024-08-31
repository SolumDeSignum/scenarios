### Upgrade Guide

Scenarios Migration to Traits
Overview

In this version, the Scenarios functionality has been refactored and moved from the src directory to a new trait inside
the SolumDeSignum\Scenarios\Traits namespace.
This change allows for better modularity, easier reuse, and more flexible integration within different parts of your application. 

### Key Changes

File Location:
The Scenarios functionality, which was previously located in src/Scenarios.php, has been moved to
src/Scenarios/Traits/Scenarios.php.

### Namespace Change:
The namespace has changed from:

```php
<?php

    declare(strict_types=1);

    use SolumDeSignum\Scenarios\Scenarios;;
````

to

```php
<?php

    declare(strict_types=1);

    use SolumDeSignum\Scenarios\Traits\Scenarios;
````

### Config Change:
The config has changed from:
```php
<?php

declare(strict_types=1);

return [
    'features' => [        
        'setMethodFromUrlSegment' => false,
        'setMethodFromController' => true,
    ],
    'methods' => [
        'pattern' => '/create|store|update|destroy/im',
    ],
];
````
to
```php
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
                'controller' => false
            ],
        ],
    ],
    'methods' => [
        'pattern' => '/create|store|update|destroy/im',
    ],
];
````
