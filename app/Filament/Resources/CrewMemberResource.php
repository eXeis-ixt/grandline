<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CrewMemberResource\Pages;
use App\Filament\Resources\CrewMemberResource\RelationManagers;
use App\Models\CrewMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;

class CrewMemberResource extends Resource
{
    protected static ?string $model = CrewMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Crew Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Member Information')
                    ->description('Basic information about the crew member')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter member name')
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('role')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter member role')
                                    ->columnSpan(1),
                            ]),
                    ]),

                Section::make('Crew & Bounty')
                    ->description('Assign crew and set bounty')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('crew_id')
                                    ->relationship('crew', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('description')
                                            ->required(),
                                        Forms\Components\Select::make('sea_id')
                                            ->relationship('sea', 'name')
                                            ->required(),
                                    ])
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('bounty')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('฿')
                                    ->inputMode('numeric')
                                    ->placeholder('Enter bounty amount')
                                    ->columnSpan(1),
                            ]),
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
                    ->description(fn (CrewMember $record): string => $record->role),
                Tables\Columns\TextColumn::make('crew.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bounty')
                    ->numeric()
                    ->sortable()
                    ->color(fn (CrewMember $record): string => $record->bounty > 1000000000 ? 'danger' : 'success'),
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
                SelectFilter::make('crew')
                    ->relationship('crew', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('bounty_range')
                    ->options([
                        'low' => 'Under 100M',
                        'medium' => '100M - 1B',
                        'high' => 'Over 1B'
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            'low' => $query->where('bounty', '<', 100000000),
                            'medium' => $query->whereBetween('bounty', [100000000, 1000000000]),
                            'high' => $query->where('bounty', '>', 1000000000),
                            default => $query
                        };
                    }),
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
            ])
            ->defaultSort('bounty', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CrewRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCrewMembers::route('/'),
            'create' => Pages\CreateCrewMember::route('/create'),
            'edit' => Pages\EditCrewMember::route('/{record}/edit'),
        ];
    }
}
