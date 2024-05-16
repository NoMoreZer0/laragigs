<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'title' => 'required',
            'company' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'website' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'tags' => 'required',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['company'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('listings', 'company')->ignore($this->listing->id),
            ];
        } else {
            $rules['company'][] = Rule::unique('listings', 'company');
        }

        return $rules;
    }
}
