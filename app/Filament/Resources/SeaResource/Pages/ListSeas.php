<?php

namespace App\Filament\Resources\SeaResource\Pages;

use App\Filament\Resources\SeaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeas extends ListRecords
{
    protected static string $resource = SeaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
