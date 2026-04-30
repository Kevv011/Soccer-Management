<?php

namespace App\Console\Commands;

use App\Jobs\ImportCountriesJob;
use App\Jobs\ImportSubdivisionsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class ImportCountriesAndSubdivisionsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'geography:import
                            {--countries : Import only countries}
                            {--subdivisions : Import only subdivisions}
                            {--queued : Dispatch the import as queued jobs}';

    /**
     * @var string
     */
    protected $description = 'Import countries and subdivisions from the configured remote endpoints.';

    public function handle(): int
    {
        $shouldImportCountries = $this->option('countries');
        $shouldImportSubdivisions = $this->option('subdivisions');

        if (! $shouldImportCountries && ! $shouldImportSubdivisions) {
            $shouldImportCountries = true;
            $shouldImportSubdivisions = true;
        }

        if ($this->option('queued')) {
            $this->dispatchQueuedImports($shouldImportCountries, $shouldImportSubdivisions);

            return self::SUCCESS;
        }

        $this->runSynchronously($shouldImportCountries, $shouldImportSubdivisions);

        return self::SUCCESS;
    }

    protected function dispatchQueuedImports(bool $shouldImportCountries, bool $shouldImportSubdivisions): void
    {
        $jobs = [];

        if ($shouldImportCountries) {
            $jobs[] = new ImportCountriesJob();
        }

        if ($shouldImportSubdivisions) {
            $jobs[] = new ImportSubdivisionsJob();
        }

        Bus::chain($jobs)->dispatch();

        $this->components->info('The geography import jobs were dispatched to the queue.');
    }

    protected function runSynchronously(bool $shouldImportCountries, bool $shouldImportSubdivisions): void
    {
        if ($shouldImportCountries) {
            $this->components->info('Importing countries...');

            /** @var array{pages: int, records: int} $result */
            $result = Bus::dispatchSync(new ImportCountriesJob());

            $this->components->info("Countries imported: {$result['records']} records across {$result['pages']} pages.");
        }

        if ($shouldImportSubdivisions) {
            $this->components->info('Importing subdivisions...');

            /** @var array{pages: int, records: int} $result */
            $result = Bus::dispatchSync(new ImportSubdivisionsJob());

            $this->components->info("Subdivisions imported: {$result['records']} records across {$result['pages']} pages.");
        }
    }
}
