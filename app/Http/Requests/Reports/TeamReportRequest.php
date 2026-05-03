<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamReportRequest extends FormRequest
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
            'all_teams' => ['nullable', 'boolean'],
            'team_ids' => [
                Rule::requiredIf(fn (): bool => ! $this->boolean('all_teams')),
                'array',
                'min:1',
            ],
            'team_ids.*' => ['integer', 'exists:teams,id'],
        ];
    }
}
