<?php

declare(strict_types=1);

namespace SolumDeSignum\Scenarios;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

use function ucfirst;

trait Scenarios
{
    /**
     * @var string
     */
    public static $controllerNamePattern = '([a-zA-Z]+)|[_]([a-zA-Z]+)[_]|[_]([a-zA-Z]+)';

    /**
     * @var string
     */
    public static $scenarioPattern = '/create|update/im';

    /**
     * @var string
     */
    public static $scenarioCreate = 'create';

    /**
     * @var string
     */
    public static $scenarioUpdate = 'update';

    /**
     * @var string
     */
    public static $scenarioDestroy = 'destroy';

    /**
     * @var string
     */
    public $scenario;

    /**
     * Scenarios constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->scenario = $this->setFromCurrentUrl();
    }

    /**
     * @param $method
     *
     * @return string|null
     */
    public function patternFilter($method): ?string
    {
        preg_match_all(self::$scenarioPattern, strtolower($method), $matches);

        return isset($matches[0][0]) === false ? $matches[0][0] : null;
    }

    /**
     * @return string|null
     */
    public function setFromCurrentUrl(): ?string
    {
        $getActionMethod = $this->patternFilter($this->currentController());
        $getRequestUri = $this->patternFilter($this->currentRequestUri());
        return $getActionMethod === $getRequestUri ? $getActionMethod :
            self::$scenarioCreate;
    }

    /**
     * @return string|null
     */
    public function currentController(): ?string
    {
        return Route::current() !== null ?
            Route::current()->getActionMethod() :
            null;
    }

    /**
     * @return string|null
     */
    public function currentRequestUri(): ?string
    {
        return Route::getCurrentRequest() !== null ?
            Route::getCurrentRequest()->getRequestUri() :
            null;
    }

    /**
     * @return string
     */
    public function currentControllerFunctionName(): string
    {
        preg_match_all(
            self::$controllerNamePattern,
            $this->currentController(),
            $matches,
            PREG_SET_ORDER,
            1
        );

        return ucfirst(
            $matches[0][1] ?? isset($matches[0][1]) ?:
                $matches[0][2] ??
                isset($matches[0][2])
        );
    }

    /**
     * @param array $data
     * @param array $callbackRule
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    public function validator(array $data, array $callbackRule)
    {
        return Validator::make($data, $callbackRule);
    }
}
