<?php

namespace App\Jobs;

use App\Actions\Geography\ImportSubdivisionsAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportSubdivisionsJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 1200;

    public int $tries = 3;

    /**
     * @return array{pages: int, records: int}
     */
    public function handle(ImportSubdivisionsAction $action): array
    {
        return $action->execute();
    }
}
