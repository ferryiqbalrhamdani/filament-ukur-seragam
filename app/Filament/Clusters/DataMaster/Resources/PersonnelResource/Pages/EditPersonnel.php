<?php

namespace App\Filament\Clusters\DataMaster\Resources\PersonnelResource\Pages;

use App\Filament\Clusters\DataMaster\Resources\PersonnelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonnel extends EditRecord
{
    protected static string $resource = PersonnelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
