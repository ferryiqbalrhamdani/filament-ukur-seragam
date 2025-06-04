<?php

namespace App\Filament\Resources\UkurSeragamResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\UkurSeragamResource;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListUkurSeragams extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = UkurSeragamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return UkurSeragamResource::getWidgets();
    }
}
