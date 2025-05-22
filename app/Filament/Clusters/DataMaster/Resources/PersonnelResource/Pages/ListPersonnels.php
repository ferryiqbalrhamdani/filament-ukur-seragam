<?php

namespace App\Filament\Clusters\DataMaster\Resources\PersonnelResource\Pages;

use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Exports\PersonnelExporter;
use App\Filament\Imports\PersonnelImporter;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use App\Filament\Clusters\DataMaster\Resources\PersonnelResource;

class ListPersonnels extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = PersonnelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(PersonnelExporter::class)
                ->icon('heroicon-o-arrow-down-tray'),
            ImportAction::make()
                ->importer(PersonnelImporter::class)
                ->color('primary')
                ->outlined()
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return PersonnelResource::getWidgets();
    }
}
