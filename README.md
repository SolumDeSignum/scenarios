### Laravel Scenarios: requires Laravel 5.x - 8.x


### Installation
You can install Laravel Scenarios through [Composer](https://getcomposer.org):

```shell
$ composer require solumdesignum/scenarios:dev-master
```

### Further steps are required please follow setup guide.


### Model Usage / Setup
```php
use SolumDeSignum\Scenarios\Scenarios;
use App\Validation\SampleRules;

class Sample extends Model
{
  use Scenarios;

  protected $table = 'sample';

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
  }
}
```


### Validation Rules Usage / Setup
```php
namespace App\Validation;
	
use SolumDeSignum\Scenarios\Scenarios;

class SampleRules
{
  public static function ScenarioRules($scenario): ?array
  {
    switch ($scenario)
    {
      case $scenario === Scenarios::$scenarioUpdate: case $scenario === Scenarios::$scenarioCreate;
        return
          [
            'text' => 'required|string',
          ];
        break;

      default: return
        [
          'text' => 'required|string',

        ];
    }
  }
}
```


### Controller Usage / Setup
```php
$validator = $this->validator($request->all(), SampleRules::ScenarioRules($this->scenario));
if ($validator->passes())
{
  #Your Logic Code
}
```


### Controller Function Naming Conventions
```php
public function doCreateMySample()
{
  #Your Logic Code
}
```


### Controller Function Naming Conventions / Model Override: Camel Case
```php
#Camel Case Conventions
public static $controllerNamePattern = "/create|update|destroy/m";

#Controller Function Naming Samples: doCreateMySample() , doUpdateMySample() , doDestroyMySample()
```


Author
-------
- [Oskars Germovs](http://solum-designum.eu) ([Twitter](https://twitter.com/faksx))


Support
-------
If you need support you can ask on [Twitter](https://twitter.com/faksx).


License
-------
The MIT License (MIT)

Copyright (c) 2018 Solum DeSignum

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit
persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
