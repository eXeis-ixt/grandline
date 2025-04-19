<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarineResource\Pages;
use App\Filament\Resources\MarineResource\RelationManagers;
use App\Models\Marine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MarineResource extends Resource
{
    protected static ?string $model = Marine::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'World Government';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('rank')
                            ->required()
                            ->options([
                                'Fleet Admiral' => 'Fleet Admiral',
                                'Admiral' => 'Admiral',
                                'Vice Admiral' => 'Vice Admiral',
                                'Rear Admiral' => 'Rear Admiral',
                                'Commodore' => 'Commodore',
                                'Captain' => 'Captain',
                                'Commander' => 'Commander',
                                'Lieutenant Commander' => 'Lieutenant Commander',
                                'Lieutenant' => 'Lieutenant',
                                'Warrant Officer' => 'Warrant Officer',
                                'Sergeant Major' => 'Sergeant Major',
                                'Sergeant' => 'Sergeant',
                                'Corporal' => 'Corporal',
                                'Seaman First Class' => 'Seaman First Class',
                                'Seaman Apprentice' => 'Seaman Apprentice',
                                'Seaman Recruit' => 'Seaman Recruit',
                            ])
                            ->searchable()
                            ->columnSpan(1),
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options([
                                'active' => 'Active',
                                'retired' => 'Retired',
                                'deceased' => 'Deceased',
                            ])
                            ->default('active')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Assignment & Details')
                    ->schema([
                        Forms\Components\Select::make('sea_id')
                            ->relationship('sea', 'name')
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('division')
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('specialty')
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('bounty')
                            ->numeric()
                            ->prefix('฿')
                            ->nullable()
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('rank')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Fleet Admiral' => 'danger',
                        'Admiral' => 'danger',
                        'Vice Admiral' => 'warning',
                        'Rear Admiral' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('bounty')
                    ->numeric()
                    ->sortable()
                    ->prefix('฿')
                    ->formatStateUsing(fn (string $state): string => number_format($state)),
                Tables\Columns\TextColumn::make('sea.name')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'retired' => 'gray',
                        'deceased' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('division')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('specialty')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rank')
                    ->options([
                        'Fleet Admiral' => 'Fleet Admiral',
                        'Admiral' => 'Admiral',
                        'Vice Admiral' => 'Vice Admiral',
                        'Rear Admiral' => 'Rear Admiral',
                        'Commodore' => 'Commodore',
                        'Captain' => 'Captain',
                        'Commander' => 'Commander',
                        'Lieutenant Commander' => 'Lieutenant Commander',
                        'Lieutenant' => 'Lieutenant',
                        'Warrant Officer' => 'Warrant Officer',
                        'Sergeant Major' => 'Sergeant Major',
                        'Sergeant' => 'Sergeant',
                        'Corporal' => 'Corporal',
                        'Seaman First Class' => 'Seaman First Class',
                        'Seaman Apprentice' => 'Seaman Apprentice',
                        'Seaman Recruit' => 'Seaman Recruit',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'retired' => 'Retired',
                        'deceased' => 'Deceased',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('sea')
                    ->relationship('sea', 'name')
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('rank', 'desc')
            ->defaultSort('name', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarines::route('/'),
            'create' => Pages\CreateMarine::route('/create'),
            'edit' => Pages\EditMarine::route('/{record}/edit'),
        ];
    }
}
