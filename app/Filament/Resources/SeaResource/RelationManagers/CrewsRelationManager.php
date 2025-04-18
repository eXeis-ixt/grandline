<?php

namespace App\Filament\Resources\SeaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Filters\Filter;

class CrewsRelationManager extends RelationManager
{
    protected static string $relationship = 'crews';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Crews';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Crew Information')
                    ->description('Basic information about the crew')
                    ->icon('heroicon-o-user-group')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter crew name'),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('URL-friendly slug'),
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->placeholder('Enter crew description')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn ($record): string => $record->description),
                Tables\Columns\TextColumn::make('members_count')
                    ->counts('members')
                    ->label('Members')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_bounty')
                    ->label('Total Bounty')
                    ->numeric()
                    ->prefix('฿')
                    ->getStateUsing(fn ($record): float => 
                        (float) $record->members->sum('bounty')
                    )
                    ->formatStateUsing(fn (float $state): string => 
                        number_format($state, 0, '.', '')
                    )
                    ->sortable()
                    ->alignment('right')
                    ->color(fn ($record): string => 
                        (float) $record->members->sum('bounty') > 1000000000 ? 'danger' : 'success'
                    ),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('total_bounty', 'desc')
            ->filters([
                Filter::make('high_bounty')
                    ->label('High Bounty Crews')
                    ->query(fn (Builder $query): Builder => 
                        $query->whereHas('members', function ($q) {
                            $q->havingRaw('SUM(bounty) > ?', [1000000000]);
                        })
                    ),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalWidth('lg'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('lg'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
} 