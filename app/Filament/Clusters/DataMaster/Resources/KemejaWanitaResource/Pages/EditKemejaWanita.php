<?php

namespace App\Filament\Clusters\DataMaster\Resources\KemejaWanitaResource\Pages;

use App\Filament\Clusters\DataMaster\Resources\KemejaWanitaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKemejaWanita extends EditRecord
{
    protected static string $resource = KemejaWanitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
