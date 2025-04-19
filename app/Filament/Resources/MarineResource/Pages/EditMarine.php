<?php

namespace App\Filament\Resources\MarineResource\Pages;

use App\Filament\Resources\MarineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarine extends EditRecord
{
    protected static string $resource = MarineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
