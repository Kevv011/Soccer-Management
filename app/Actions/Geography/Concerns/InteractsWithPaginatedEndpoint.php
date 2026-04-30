<?php

namespace App\Actions\Geography\Concerns;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait InteractsWithPaginatedEndpoint
{
    /**
     * @return iterable<array{data: array<int, array<string, mixed>>, next_url: ?string}>
     */
    protected function fetchPaginatedData(string $url): iterable
    {
        $nextUrl = $url;

        while (filled($nextUrl)) {
            $response = $this->makeRequest($nextUrl);
            $payload = $response->json();

            $data = $payload['data'] ?? null;

            if (! is_array($data)) {
                throw new \RuntimeException("The geography import endpoint [{$nextUrl}] returned an invalid payload.");
            }

            yield [
                'data' => $data,
                'next_url' => $payload['links']['next'] ?? null,
            ];

            $nextUrl = $payload['links']['next'] ?? null;
        }
    }

    protected function makeRequest(string $url): Response
    {
        $response = Http::acceptJson()
            ->connectTimeout((int) config('services.geography_import.connect_timeout', 5))
            ->timeout((int) config('services.geography_import.timeout', 30))
            ->retry(3, 200)
            ->get($url);

        $response->throw();

        return $response;
    }
}
