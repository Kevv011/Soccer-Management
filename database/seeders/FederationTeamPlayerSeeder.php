<?php

namespace Database\Seeders;

use App\Models\Federation;
use App\Models\Player;
use App\Models\Subdivision;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FederationTeamPlayerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->pruneDomainData();

        $federationImagePaths = collect(File::files(public_path('images/federations')))
            ->sortBy(fn (\SplFileInfo $file): string => $file->getFilename())
            ->values();

        if ($federationImagePaths->count() !== 11) {
            throw new \RuntimeException('Expected exactly 11 federation images in public/images/federations.');
        }

        $subdivisions = Subdivision::query()
            ->with('country')
            ->inRandomOrder()
            ->limit($federationImagePaths->count())
            ->get();

        if ($subdivisions->count() < $federationImagePaths->count()) {
            throw new \RuntimeException('At least 11 subdivisions are required before running the federation seeder.');
        }

        $teamCrestPath = public_path('images/soccer-team.png');

        if (! File::exists($teamCrestPath)) {
            throw new \RuntimeException('The team crest file public/images/soccer-team.png does not exist.');
        }

        $federationDefinitions = $this->federationDefinitions();

        $subdivisions
            ->zip($federationImagePaths)
            ->each(function (Collection $pair, int $index) use ($federationDefinitions, $teamCrestPath): void {
                /** @var Subdivision $subdivision */
                $subdivision = $pair->get(0);
                /** @var \SplFileInfo $image */
                $image = $pair->get(1);
                $definition = $federationDefinitions[$index];

                $federation = Federation::query()->create([
                    'name' => $definition['name'],
                    'subdivision_id' => $subdivision->id,
                    'municipality' => $definition['municipality'],
                    'foundation_date' => $definition['foundation_date'],
                    'address_line' => $definition['address_line'],
                ]);

                $this->attachFederationLogo($federation, $image->getPathname());

                $teams = $this->seedTeamsForFederation(
                    federation: $federation,
                    teamCrestPath: $teamCrestPath,
                    teamCount: 3 + ($index % 3),
                );

                $teams->each(function (Team $team): void {
                    $team->players()->delete();

                    Player::factory()
                        ->count(fake()->numberBetween(18, 24))
                        ->for($team)
                        ->create();
                });
            });
    }

    protected function pruneDomainData(): void
    {
        Player::query()->delete();

        Team::query()->get()->each(function (Team $team): void {
            $team->clearMediaCollection('crest');
            $team->delete();
        });

        Federation::query()->get()->each(function (Federation $federation): void {
            $federation->clearMediaCollection('logo');
            $federation->delete();
        });
    }

    /**
     * @return array<int, array{name: string, municipality: string, foundation_date: string, address_line: string}>
     */
    protected function federationDefinitions(): array
    {
        return [
            [
                'name' => 'Northern Football Federation',
                'municipality' => 'North City',
                'foundation_date' => '1952-03-14',
                'address_line' => 'Central Avenue 101',
            ],
            [
                'name' => 'Pacific Football Federation',
                'municipality' => 'Pacific Town',
                'foundation_date' => '1961-07-09',
                'address_line' => 'Harbor District 22',
            ],
            [
                'name' => 'Andean Football Federation',
                'municipality' => 'Andean Capital',
                'foundation_date' => '1948-01-26',
                'address_line' => 'Mountain Boulevard 87',
            ],
            [
                'name' => 'Metropolitan Football Federation',
                'municipality' => 'Metro Center',
                'foundation_date' => '1973-11-02',
                'address_line' => 'Executive Plaza 14',
            ],
            [
                'name' => 'Southern Football Federation',
                'municipality' => 'South Port',
                'foundation_date' => '1958-05-30',
                'address_line' => 'Liberty Street 230',
            ],
            [
                'name' => 'Eastern Football Federation',
                'municipality' => 'East Valley',
                'foundation_date' => '1982-09-18',
                'address_line' => 'Sports Complex 5',
            ],
            [
                'name' => 'Western Football Federation',
                'municipality' => 'West Ridge',
                'foundation_date' => '1967-02-11',
                'address_line' => 'Sunset Avenue 19',
            ],
            [
                'name' => 'Central Football Federation',
                'municipality' => 'Central District',
                'foundation_date' => '1945-08-21',
                'address_line' => 'Main Stadium Road 1',
            ],
            [
                'name' => 'Highlands Football Federation',
                'municipality' => 'Highlands City',
                'foundation_date' => '1979-04-17',
                'address_line' => 'Pine Street 44',
            ],
            [
                'name' => 'Riverlands Football Federation',
                'municipality' => 'Riverlands',
                'foundation_date' => '1990-06-06',
                'address_line' => 'Riverside Walk 73',
            ],
            [
                'name' => 'Coastal Football Federation',
                'municipality' => 'Coastal Bay',
                'foundation_date' => '1969-12-12',
                'address_line' => 'Oceanfront Drive 9',
            ],
        ];
    }

    protected function attachFederationLogo(Federation $federation, string $path): void
    {
        $federation
            ->addMedia($path)
            ->preservingOriginal()
            ->usingFileName(basename($path))
            ->usingName(pathinfo($path, PATHINFO_FILENAME))
            ->toMediaCollection('logo');
    }

    /**
     * @return Collection<int, Team>
     */
    protected function seedTeamsForFederation(Federation $federation, string $teamCrestPath, int $teamCount): Collection
    {
        $teamNames = $this->generateTeamNames($federation->name, $teamCount);

        return collect($teamNames)->map(function (string $teamName) use ($federation, $teamCrestPath): Team {
            $team = Team::query()->create([
                'federation_id' => $federation->id,
                'name' => $teamName,
            ]);

            $team
                ->addMedia($teamCrestPath)
                ->preservingOriginal()
                ->usingFileName(basename($teamCrestPath))
                ->usingName($teamName . ' Crest')
                ->toMediaCollection('crest');

            return $team;
        });
    }

    /**
     * @return array<int, string>
     */
    protected function generateTeamNames(string $federationName, int $count): array
    {
        $prefix = Str::of($federationName)
            ->replace('Football Federation', '')
            ->trim()
            ->toString();

        $suffixes = [
            'United',
            'Sporting',
            'Athletic',
            'Club',
            'Academy',
            'Rovers',
            'City',
            'FC',
        ];

        return collect($suffixes)
            ->shuffle()
            ->take($count)
            ->values()
            ->map(fn (string $suffix): string => trim("{$prefix} {$suffix}"))
            ->all();
    }
}
