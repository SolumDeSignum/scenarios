<?php

declare(strict_types=1);

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
