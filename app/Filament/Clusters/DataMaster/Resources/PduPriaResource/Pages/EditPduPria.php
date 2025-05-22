<?php

namespace App\Filament\Clusters\DataMaster\Resources\PduPriaResource\Pages;

use App\Filament\Clusters\DataMaster\Resources\PduPriaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPduPria extends EditRecord
{
    protected static string $resource = PduPriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
