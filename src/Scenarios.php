<?php

declare(strict_types=1);

namespace SolumDeSignum\Scenarios;

use Illuminate\Support\Facades\Route;

use function config;
use function is_bool;

trait Scenarios
{
    /**
     * @var string
     */
    public $scenario;

    /**
     * @var string
     */
    public $setMethodFromController;

    /**
     * @var string
     */
    public $setMethodFromUrl;

    /**
     * Create a new rule instance.
     *
     * Scenarios constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        // Set Config
        $this->setMethodFromController = config(
            'scenarios.features.setMethodFromController',
            true
        );
        $this->setMethodFromUrl = config(
            'scenarios.features.setMethodFromUrlSegment',
            false
        );

        // Detect package abuse
        $this->exceptionOneSetMethod();
        $this->exceptionOnlyOneSetMethod();

        // setMethod based on Controller function
        if ($this->setMethodFromController) {
            $this->scenario = $this->patternFilter($this->currentControllerMethod());
        }

        // setMethod based on Request segment based on $controllerMethodPattern
        if ($this->setMethodFromUrl) {
            $this->scenario = $this->patternFilter($this->currentRequestUri());
        }
    }

    /**
     * @param $method
     *
     * @return string
     * @throws \Exception
     */
    public function patternFilter($method): string
    {
        preg_match_all(
            config('scenarios.methods.pattern'),
            strtolower($method),
            $matches
        );

        $this->exceptionScenarioPattern($matches[0][0]);

        return $matches[0][0];
    }

    /**
     * @return string|null
     */
    public function currentControllerMethod(): ?string
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
     * @param mixed $matches
     *
     * @throws \Exception
     */
    private function exceptionScenarioPattern($matches): void
    {
        if (isset($matches) === false) {
            throw new \Exception(
                'Scenarios patternFilter failed finding match, check $scenarioPattern , LIKE RIGHT NOW !!!'
            );
        }
    }

    private function exceptionOneSetMethod(): void
    {
        if (
            is_bool($this->setMethodFromController) === false ||
            is_bool($this->setMethodFromUrl) === false ||
            ($this->setMethodFromController === false && $this->setMethodFromUrl === false)
        ) {
            throw new \Exception(
                'Please enable at least one setMethod function, LIKE RIGHT NOW !!!'
            );
        }
    }

    private function exceptionOnlyOneSetMethod(): void
    {
        if (
            is_bool($this->setMethodFromController) === false ||
            is_bool($this->setMethodFromUrl) === false ||
            ($this->setMethodFromController === true && $this->setMethodFromUrl === true)
        ) {
            throw new \Exception(
                'Please enable only one setMethod function, LIKE RIGHT NOW !!!'
            );
        }
    }
}
