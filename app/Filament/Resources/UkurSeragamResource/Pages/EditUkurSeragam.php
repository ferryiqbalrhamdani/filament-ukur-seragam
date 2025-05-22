<?php

namespace App\Filament\Resources\UkurSeragamResource\Pages;

use App\Filament\Resources\UkurSeragamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUkurSeragam extends EditRecord
{
    protected static string $resource = UkurSeragamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
