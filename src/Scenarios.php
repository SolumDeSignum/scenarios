<?php

declare(strict_types=1);

namespace SolumDeSignum\Scenarios;

use Exception;
use Illuminate\Support\Facades\Route;

trait Scenarios
{
    public string $scenario;

    public mixed $setMethodFromController;

    public mixed $setMethodFromUrl;

    /**
     * Create a new rule instance.
     *
     * Scenarios constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->setMethodFromController = config('scenarios.features.setMethodFromController', true);
        $this->setMethodFromUrl = config('scenarios.features.setMethodFromUrlSegment', false);

        $this->exceptionOneSetMethod();
        $this->exceptionOnlyOneSetMethod();

        if ($this->setMethodFromController) {
            $this->scenario = $this->patternFilter($this->currentControllerMethod());
        }

        if ($this->setMethodFromUrl) {
            $this->scenario = $this->patternFilter($this->currentRequestUri());
        }
    }

    /**
     * @throws Exception
     */
    public function exceptionOneSetMethod(): void
    {
        if (
            !is_bool($this->setMethodFromController) ||
            !is_bool($this->setMethodFromUrl) ||
            ($this->setMethodFromController === false && $this->setMethodFromUrl === false)
        ) {
            throw new Exception(
                'Please enable at least one setMethod function, LIKE RIGHT NOW !!!'
            );
        }
    }

    /**
     * @throws Exception
     */
    public function exceptionOnlyOneSetMethod(): void
    {
        if (
            !is_bool($this->setMethodFromController) ||
            !is_bool($this->setMethodFromUrl) ||
            ($this->setMethodFromController === true && $this->setMethodFromUrl === true)
        ) {
            throw new Exception(
                'Please enable only one setMethod function, LIKE RIGHT NOW !!!'
            );
        }
    }

    /**
     * @throws Exception
     */
    public function patternFilter(string $method): string
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
     * @throws Exception
     */
    public function exceptionScenarioPattern(mixed $matches): void
    {
        if (!isset($matches)) {
            throw new Exception(
                'Scenarios patternFilter failed finding match, check $scenarioPattern , LIKE RIGHT NOW !!!'
            );
        }
    }

    public function currentControllerMethod(): ?string
    {
        return Route::current() !== null ?
            Route::current()->getActionMethod() :
            null;
    }

    public function currentRequestUri(): ?string
    {
        return Route::getCurrentRequest() !== null ?
            Route::getCurrentRequest()->getRequestUri() :
            null;
    }
}
