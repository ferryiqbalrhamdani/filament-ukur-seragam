<?php

namespace App\Filament\Resources\UkurSeragamResource\Pages;

use App\Filament\Resources\UkurSeragamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUkurSeragams extends ListRecords
{
    protected static string $resource = UkurSeragamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
