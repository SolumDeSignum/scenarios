<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use SolumDeSignum\Scenarios\Traits\Scenarios;

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
