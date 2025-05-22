<?php

namespace App\Filament\Clusters\DataMaster\Resources\PersonnelResource\Pages;

use App\Filament\Clusters\DataMaster\Resources\PersonnelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePersonnel extends CreateRecord
{
    protected static string $resource = PersonnelResource::class;
}
