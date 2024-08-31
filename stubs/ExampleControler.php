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
