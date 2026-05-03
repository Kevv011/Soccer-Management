<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FederationReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('panel.access') ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'all_federations' => ['nullable', 'boolean'],
            'federation_ids' => [
                Rule::requiredIf(fn (): bool => ! $this->boolean('all_federations')),
                'array',
                'min:1',
            ],
            'federation_ids.*' => ['integer', 'exists:federations,id'],
        ];
    }
}
