[![StyleCI](https://github.styleci.io/repos/145921620/shield?branch=master)](https://github.styleci.io/repos/145921620)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SolumDeSignum/scenarios/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SolumDeSignum/scenarios/?branch=master)
[![Total Downloads](https://poser.pugx.org/solumdesignum/scenarios/downloads?format=flat)](https://packagist.org/packages/solumdesignum/scenarios)
[![Latest Stable Version](https://poser.pugx.org/solumdesignum/scenarios/v/stable?format=flat)](https://packagist.org/packages/solumdesignum/scenarios)
[![Latest Unstable Version](https://poser.pugx.org/solumdesignum/scenarios/v/unstable?format=flat)](https://packagist.org/packages/solumdesignum/scenarios)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

### Introduction
Scenarios are agnostic backend validation Scenarios package.


### Installation
To get started, install Scenarios using the Composer package manager:
```shell
composer require solumdesignum/scenarios
```

Next, publish Scenarios resources using the vendor:publish command:

```shell
php artisan vendor:publish --provider="SolumDeSignum\Scenarios\ScenariosServiceProvider"
```

This command will publish scenarios.php config to your config directory, which will be created if it does not exist.

### Upgrade from v1.xx to version v2.00
[UPGRADE_V2.md](UPGRADE_V2.md) !!!

### Scenarios Features
The Scenarios configuration file contains a configuration array.
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
                'controller' => true
            ],
        ],
    ],
    'methods' => [
        'pattern' => '/create|store|update|destroy/im',
    ],
];
````

### Scenario's with Controller
Before using it must change config 
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
Now we are prepared to use it in controller.
```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SolumDeSignum\Scenarios\Traits\Scenarios;

class ExampleControler extends Controller
{
    use Scenarios;

    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        dump($this);
        dd($this->scenario);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        if ($this->scenario === 'create') {
            // my logic
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        if ($this->scenario === 'store') {
            // my logic
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        dump($this);
        dd($this->scenario);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void
    {
        dump($this);
        dd($this->scenario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        if ($this->scenario === 'update') {
            // my logic
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        if ($this->scenario === 'destroy') {
            // my logic
        }
    }
}
````

### Scenario's with your Form Request Validation

```php
<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use SolumDeSignum\Scenarios\Traits\Scenarios;

class OfficeBlogRequest extends FormRequest
{
    use Scenarios;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        if ($this->scenario === 'store') {
            $rules = [
                'title' => 'required|string',
                'publish_at' => 'required',
                'blog_category_id' => 'required|numeric',
                'description' => 'required',
            ];
        }

        if ($this->scenario === 'update') {
            $rules = [
                'title' => 'required|string',
                'publish_at' => 'required',
                'blog_category_id' => 'required|numeric',
                'description' => 'required',
                'img' => 'image',
            ];
        }

        if ($this->scenario === 'destroy') {
            $rules = [];
        }

        return $rules;
    }
}
````


### Validation Rules Usage
#### However, can be used on both examples

```php
namespace App\Validation;
	
class SampleRules
{
  public static function ScenarioRules(string $scenario): ?array
  {
        switch ($scenario) {
            case $scenario === 'store';
                return
                    [
                        'text' => 'required|string',
                    ];
                break;

            case $scenario === 'update';
                return
                    [
                        'text' => 'required|string',
                        'description' => 'required|string',
                    ];
                break;
        }
  }
}
```

### Scenario's With Controller 
#### Manually Creating Validators

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers\Office\Blog;

use App\Validation\SampleRules;
use Illuminate\Support\Facades\Validator;
use SolumDeSignum\Scenarios\Traits\Scenarios;

class BlogController
{
    use Scenarios;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), SampleRules::ScenarioRules($this->scenario));
        if ($validator->passes()) {
            #Your Logic Code
        }
    }
}
```


### Controller Functions Names Examples
#### However, you can override regex with your naming conventions inside configuration
```php
<?php

declare(strict_types=1);

return [
    'methods' => [
        'pattern' => '/create|store|update|destroy/im'
    ]
];

#Controller Function Naming Samples: create(), store() , update() , destroy()
```


Author
-------
- [Oskars Germovs](http://solum-designum.eu) ([Twitter](https://twitter.com/faksx))


Support
-------
If you need support you can ask on [Twitter](https://twitter.com/faksx).


License
-------
Solum DeSignum Scenarios is open-sourced software licensed under the [MIT license](LICENSE.md).
