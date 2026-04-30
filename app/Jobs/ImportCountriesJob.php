<?php

namespace App\Jobs;

use App\Actions\Geography\ImportCountriesAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportCountriesJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 1200;

    public int $tries = 3;

    /**
     * @return array{pages: int, records: int}
     */
    public function handle(ImportCountriesAction $action): array
    {
        return $action->execute();
    }
}
