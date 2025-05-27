<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CrewResource\Pages;
use App\Filament\Resources\CrewResource\RelationManagers;
use App\Models\Crew;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Str;
use Filament\Tables\Filters\SelectFilter;

class CrewResource extends Resource
{
    protected static ?string $model = Crew::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Crew Management';

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
                Section::make('Basic Information')
                    ->description('Enter the crew\'s basic details')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter crew name')
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
                        Forms\Components\Select::make('sea_id')
                            ->relationship('sea', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->placeholder('Enter crew description')
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
                    ->description(fn (Crew $record): string => Str::limit($record->description, 100)),
                Tables\Columns\TextColumn::make('sea.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('members_count')
                    ->counts('members')
                    ->label('Members')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_bounty')
                    ->label('Total Bounty') 
                    ->getStateUsing(fn (Crew $record): float => $record->members->sum('bounty'))
                    ->sortable()
                    ->alignment('right')
                    ->color(fn (Crew $record): string => $record->members->sum('bounty') > 1000000000 ? 'danger' : 'success'),
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
                SelectFilter::make('sea')
                    ->relationship('sea', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('total_bounty')
                    ->options([
                        'low' => 'Under 500M',
                        'medium' => '500M - 5B',
                        'high' => 'Over 5B'
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            'low' => $query->whereHas('members', function ($q) {
                                $q->havingRaw('SUM(bounty) < ?', [500000000]);
                            }),
                            'medium' => $query->whereHas('members', function ($q) {
                                $q->havingRaw('SUM(bounty) BETWEEN ? AND ?', [500000000, 5000000000]);
                            }),
                            'high' => $query->whereHas('members', function ($q) {
                                $q->havingRaw('SUM(bounty) > ?', [5000000000]);
                            }),
                            default => $query
                        };
                    }),
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
            RelationManagers\MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCrews::route('/'),
            'create' => Pages\CreateCrew::route('/create'),
            'edit' => Pages\EditCrew::route('/{record}/edit'),
        ];
    }
} 
