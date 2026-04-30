<?php

namespace App\Actions\Geography;

use App\Actions\Geography\Concerns\InteractsWithPaginatedEndpoint;
use App\Models\Country;
use App\Models\Subdivision;
use Carbon\CarbonImmutable;

class ImportSubdivisionsAction
{
    use InteractsWithPaginatedEndpoint;

    /**
     * @return array{pages: int, records: int}
     */
    public function execute(): array
    {
        $url = (string) config('services.geography_import.subdivisions_url');

        $pages = 0;
        $records = 0;

        foreach ($this->fetchPaginatedData($url) as $page) {
            $this->guardAgainstMissingCountries($page['data']);

            $rows = array_map(
                fn (array $subdivision): array => [
                    'country_id' => (int) $subdivision['country_id'],
                    'code' => (string) $subdivision['code'],
                    'name' => (string) $subdivision['name'],
                    'created_at' => $this->normalizeTimestamp($subdivision['created_at'] ?? null),
                    'updated_at' => $this->normalizeTimestamp($subdivision['updated_at'] ?? null),
                ],
                $page['data'],
            );

            if ($rows !== []) {
                Subdivision::query()->upsert(
                    $rows,
                    ['country_id', 'code'],
                    ['name', 'created_at', 'updated_at'],
                );
            }

            $pages++;
            $records += count($rows);
        }

        return [
            'pages' => $pages,
            'records' => $records,
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $subdivisions
     */
    protected function guardAgainstMissingCountries(array $subdivisions): void
    {
        $countryIds = collect($subdivisions)
            ->pluck('country_id')
            ->filter()
            ->map(static fn (mixed $id): int => (int) $id)
            ->unique()
            ->values();

        if ($countryIds->isEmpty()) {
            return;
        }

        $existingCountryIds = Country::query()
            ->whereIn('id', $countryIds)
            ->pluck('id');

        $missingCountryIds = $countryIds->diff($existingCountryIds)->values()->all();

        if ($missingCountryIds === []) {
            return;
        }

        throw new \RuntimeException(
            'The subdivisions import payload references missing countries: ' . implode(', ', $missingCountryIds),
        );
    }

    protected function normalizeTimestamp(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        return CarbonImmutable::parse((string) $value)->toDateTimeString();
    }
}
