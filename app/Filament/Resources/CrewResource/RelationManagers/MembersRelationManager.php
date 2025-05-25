<?php

namespace App\Filament\Resources\CrewResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\FontWeight;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Crew Members';

    public function form(Form $form): Form
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
                                    ->placeholder('Enter member name'),
                                Forms\Components\TextInput::make('role')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter member role'),
                                Forms\Components\TextInput::make('bounty')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('฿')
                                    ->inputMode('numeric')
                                    ->placeholder('Enter bounty amount')
                                    ->columnSpanFull(),
                            ]),
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
                    ->description(fn ($record): string => $record->role),
                Tables\Columns\TextColumn::make('bounty')
                    ->money('B')
                    ->sortable()
                    ->alignment('right')
                    ->color(fn ($record): string => $record->bounty > 1000000000 ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('bounty', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'Captain' => 'Captain',
                        'First Mate' => 'First Mate',
                        'Navigator' => 'Navigator',
                        'Cook' => 'Cook',
                        'Doctor' => 'Doctor',
                        'Sniper' => 'Sniper',
                        'Swordsman' => 'Swordsman',
                        'Shipwright' => 'Shipwright',
                        'Musician' => 'Musician',
                        'Archaeologist' => 'Archaeologist',
                    ]),
                Tables\Filters\Filter::make('high_bounty')
                    ->label('High Bounty (Over 1B)')
                    ->query(fn (Builder $query): Builder => $query->where('bounty', '>', 1000000000)),
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
