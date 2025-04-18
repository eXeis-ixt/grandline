<?php

namespace App\Filament\Resources\SeaResource\Pages;

use App\Filament\Resources\SeaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSea extends EditRecord
{
    protected static string $resource = SeaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
