<?php

namespace App\Filament\Clusters\DataMaster\Resources\CelanaPduWanitaResource\Pages;

use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\DataMaster\Resources\CelanaPduWanitaResource;
use App\Filament\Exports\CelanaPduWanitaExporter;
use App\Filament\Imports\CelanaPduWanitaImporter;

class ListCelanaPduWanitas extends ListRecords
{
    protected static string $resource = CelanaPduWanitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(CelanaPduWanitaExporter::class)
                ->icon('heroicon-o-arrow-down-tray'),
            ImportAction::make()
                ->importer(CelanaPduWanitaImporter::class)
                ->color('primary')
                ->outlined()
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
