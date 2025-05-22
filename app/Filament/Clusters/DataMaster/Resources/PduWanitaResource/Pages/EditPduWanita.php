<?php

namespace App\Filament\Clusters\DataMaster\Resources\PduWanitaResource\Pages;

use App\Filament\Clusters\DataMaster\Resources\PduWanitaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPduWanita extends EditRecord
{
    protected static string $resource = PduWanitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
