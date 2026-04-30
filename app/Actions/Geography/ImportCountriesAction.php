<?php

namespace App\Actions\Geography;

use App\Actions\Geography\Concerns\InteractsWithPaginatedEndpoint;
use App\Models\Country;
use Carbon\CarbonImmutable;

class ImportCountriesAction
{
    use InteractsWithPaginatedEndpoint;

    /**
     * @return array{pages: int, records: int}
     */
    public function execute(): array
    {
        $url = (string) config('services.geography_import.countries_url');

        $pages = 0;
        $records = 0;

        foreach ($this->fetchPaginatedData($url) as $page) {
            $rows = array_map(
                fn (array $country): array => [
                    'id' => (int) $country['id'],
                    'iso_name' => (string) $country['iso_name'],
                    'iso' => (string) $country['iso'],
                    'iso3' => (string) $country['iso3'],
                    'name' => (string) $country['name'],
                    'created_at' => $this->normalizeTimestamp($country['created_at'] ?? null),
                    'updated_at' => $this->normalizeTimestamp($country['updated_at'] ?? null),
                ],
                $page['data'],
            );

            if ($rows !== []) {
                Country::query()->upsert(
                    $rows,
                    ['id'],
                    ['iso_name', 'iso', 'iso3', 'name', 'created_at', 'updated_at'],
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

    protected function normalizeTimestamp(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        return CarbonImmutable::parse((string) $value)->toDateTimeString();
    }
}
