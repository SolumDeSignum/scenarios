<?php

declare(strict_types=1);

namespace SolumDeSignum\Scenarios\Traits;

use Exception;
use Illuminate\Support\Facades\Route;

trait Scenarios
{
    public string $scenario;

    public bool $setMethodFromController;

    public bool $setMethodFromUrl;

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

        $this->validateConfiguration();

        if ($this->setMethodFromController) {
            $this->scenario = $this->filterPattern($this->currentControllerMethod());
        } elseif ($this->setMethodFromUrl) {
            $this->scenario = $this->filterPattern($this->currentRequestUri());
        }
    }

    /**
     * Validates the configuration to ensure only one method is enabled.
     *
     * @throws Exception
     */
    public function validateConfiguration(): void
    {
        $message = null;

        if ($this->setMethodFromController === false && $this->setMethodFromUrl === false) {
            $message = 'Please enable at least one setMethod function.';
        }

        if ($this->setMethodFromController === true && $this->setMethodFromUrl === true) {
            $message = 'Please enable only one setMethod function.';
        }

        if ($message !== null) {
            throw new Exception($message);
        }
    }

    /**
     * Filters the pattern from the provided method.
     *
     * @param string|null $method
     * @param string|null $overridePattern
     * @return mixed
     * @throws Exception
     */
    public function filterPattern(?string $method, ?string $overridePattern = null): mixed
    {
        $message = null;

        if (empty($method)) {
            $matches = null;
            $message = 'Unable to determine the method for pattern filtering.';
        } else {
            preg_match_all(
                $overridePattern !== null
                    ? $overridePattern
                    : config('scenarios.methods.pattern'),
                strtolower($method),
                $matches
            );
        }

        if (empty($matches[0]) && !empty($method)) {
            $message = 'No pattern matches found. Check the scenario pattern configuration.';
        }

        if ($message !== null) {
            throw new Exception($message);
        }

        return $matches[0][0];
    }

    /**
     * Gets the current controller method.
     *
     * @return string|null
     */
    public function currentControllerMethod(): ?string
    {
        return Route::current() !== null ?
            Route::current()->getActionMethod() :
            null;
    }

    /**
     * Gets the current request URI.
     *
     * @return string|null
     */
    public function currentRequestUri(): ?string
    {
        return Route::getCurrentRequest() !== null ?
            Route::getCurrentRequest()->getRequestUri() :
            null;
    }
}
