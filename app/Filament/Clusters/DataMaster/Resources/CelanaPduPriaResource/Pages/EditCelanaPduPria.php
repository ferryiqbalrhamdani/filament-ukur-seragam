<?php

namespace App\Filament\Clusters\DataMaster\Resources\CelanaPduPriaResource\Pages;

use App\Filament\Clusters\DataMaster\Resources\CelanaPduPriaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCelanaPduPria extends EditRecord
{
    protected static string $resource = CelanaPduPriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
