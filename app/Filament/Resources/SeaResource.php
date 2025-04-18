<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeaResource\Pages;
use App\Filament\Resources\SeaResource\RelationManagers;
use App\Models\Sea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Str;

class SeaResource extends Resource
{
    protected static ?string $model = Sea::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'World Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sea Information')
                    ->description('Enter the sea\'s basic details')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter sea name')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                        $set('slug', Str::slug($state));
                                    }),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('URL-friendly slug')
                                    ->unique(ignoreRecord: true),
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->placeholder('Enter sea description')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn (Sea $record): string => Str::limit($record->description, 100)),
                Tables\Columns\TextColumn::make('crews_count')
                    ->counts('crews')
                    ->label('Crews')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_bounty')
                    ->label('Total Bounty')
                    ->numeric()
                    ->prefix('฿')
                    ->getStateUsing(fn (Sea $record): float => 
                        (float) $record->crews->sum(fn ($crew) => 
                            (float) $crew->members->sum('bounty')
                        )
                    )
                    ->formatStateUsing(fn (float $state): string => 
                        number_format($state, 0, '.', '')
                    )
                    ->sortable()
                    ->alignment('right')
                    ->color(fn (Sea $record): string => 
                        (float) $record->crews->sum(fn ($crew) => 
                            (float) $crew->members->sum('bounty')
                        ) > 1000000000 ? 'danger' : 'success'
                    ),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('high_bounty')
                    ->label('High Bounty Seas')
                    ->query(fn (Builder $query): Builder => 
                        $query->whereHas('crews.members', function ($q) {
                            $q->havingRaw('SUM(bounty) > ?', [1000000000]);
                        })
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('lg'),
                Tables\Actions\ViewAction::make()
                    ->modalWidth('lg'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CrewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeas::route('/'),
            'create' => Pages\CreateSea::route('/create'),
            'edit' => Pages\EditSea::route('/{record}/edit'),
        ];
    }
}
