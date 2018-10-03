### Laravel Scenarios: requires Laravel 5.x


### Installation
You can install Laravel Scenarios through [Composer](https://getcomposer.org):

```shell
$ composer require solumdesignum/scenarios:dev-master
```

### Further steps are required please follow setup guide.

### Model Usage / Setup
```php
use SolumDeSignum\Scenarios\Scenarios;
use App\Validation\Sample_Rules;

class Sample extends Model
{
  use Scenarios;

  protected $table = 'sample';

  public function __construct()
  {
    $this->Scenario_Set_From_Current_Url();
    parent::__construct();
  }

  public function Dynamic_Rules(array $data)
  {
    return Validator::make($data , Sample_Rules::Scenario_Rules($this->Scenario));
  }

  public function init()
  {
    return new self();
  }
}
```


### Validation Rules Usage / Setup
```php
namespace App\Validation;
	
use SolumDeSignum\Scenarios\Scenarios;

class Sample_Rules
{
  public static function Scenario_Rules($scenario)
  {
    switch ($scenario)
    {
      case $scenario == Scenarios::$SCENARIO_CREATE;
        return
          [
            'text' => 'required|string',
          ];
        break;

      case $scenario == Scenarios::$SCENARIO_UPDATE;
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
$validator = Sample::init()->Dynamic_Rules($request->all());
if ($validator->passes())
{
  #Your Logic Code
}
```


### Controller Function Naming Conventions
```php
public function Do_Create_My_Sample()
{
  #Your Logic Code
}
```


### Controller Function Naming Conventions / Model Override: Camel Case
```php
#Camel Case Conventions
public static $CURRENT_CONTROLLER_NAME_PATTERN = "/Create|Update|Destroy/m";

#Controller Function Naming Samples: DoCreateMySample() , DoUpdateMySample() , DoDestroyMySample()
```


Author
-------
- [Jonh Mark](http://solum-designum.com) ([Twitter](https://twitter.com/faksx))


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
