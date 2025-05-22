<?php

namespace App\Filament\Clusters\DataMaster\Resources\CelanaPduWanitaResource\Pages;

use App\Filament\Clusters\DataMaster\Resources\CelanaPduWanitaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCelanaPduWanita extends EditRecord
{
    protected static string $resource = CelanaPduWanitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
