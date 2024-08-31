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
