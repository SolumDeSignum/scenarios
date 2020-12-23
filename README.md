[![StyleCI](https://github.styleci.io/repos/145921620/shield?branch=master)](https://github.styleci.io/repos/145921620)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SolumDeSignum/scenarios/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SolumDeSignum/scenarios/?branch=master)
[![Total Downloads](https://poser.pugx.org/solumdesignum/scenarios/downloads?format=flat)](https://packagist.org/packages/solumdesignum/scenarios)
[![Latest Stable Version](https://poser.pugx.org/solumdesignum/scenarios/v/stable?format=flat)](https://packagist.org/packages/solumdesignum/scenarios)
[![Latest Unstable Version](https://poser.pugx.org/solumdesignum/scenarios/v/unstable?format=flat)](https://packagist.org/packages/solumdesignum/scenarios)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

### Introduction
Solum DeSignum Scenarios is agnostic backend validation Scenarios package.


### Installation
To get started, install Scenarios using the Composer package manager:
```shell
composer require solumdesignum/scenarios
```

Next, publish Scenarios resources using the vendor:publish command:

```shell
php artisan vendor:publish --provider="SolumDeSignum\Scenarios\ScenariosServiceProvider"
```

This command will publish Scenarios config to your config directory, which will be
 created if it does not exist.


### Scenarios Features
The Scenarios configuration file contains a configuration array.
```php
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
````

### Scenario's With Form Request Validation
```php
<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use SolumDeSignum\Scenarios\Scenarios;


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
	
use SolumDeSignum\Scenarios\Scenarios;

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

use Illuminate\Support\Facades\Validator;
use SolumDeSignum\Scenarios\Scenarios;
use App\Validation\SampleRules;

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
