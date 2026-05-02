<?php

namespace App\Filament\Resources\Players\Tables;

use App\Enums\PlayerGender;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PlayersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('team.name')
                    ->label('Team')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('team.federation.name')
                    ->label('Federation')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->badge()
                    ->formatStateUsing(function (PlayerGender | string | null $state): string {
                        if ($state instanceof PlayerGender) {
                            return PlayerGender::options()[$state->value] ?? $state->value;
                        }

                        if (blank($state)) {
                            return '-';
                        }

                        return PlayerGender::options()[$state] ?? $state;
                    }),
                TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('team')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('gender')
                    ->options(PlayerGender::options()),
                SelectFilter::make('federation')
                    ->options(fn (): array => \App\Models\Federation::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        filled($data['value'] ?? null),
                        fn (Builder $query): Builder => $query->whereHas('team', fn (Builder $teamQuery): Builder => $teamQuery->where('federation_id', $data['value'])),
                    )),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
