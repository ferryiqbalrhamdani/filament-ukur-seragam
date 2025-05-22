<?php

namespace App\Filament\Clusters\DataMaster\Resources\KemejaPriaResource\Pages;

use App\Filament\Clusters\DataMaster\Resources\KemejaPriaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKemejaPria extends EditRecord
{
    protected static string $resource = KemejaPriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
