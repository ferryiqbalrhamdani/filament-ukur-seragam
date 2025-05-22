<?php

namespace App\Filament\Clusters\DataMaster\Resources\KemejaWanitaResource\Pages;

use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\DataMaster\Resources\KemejaWanitaResource;
use App\Filament\Exports\KemejaWanitaExporter;
use App\Filament\Imports\KemejaWanitaImporter;

class ListKemejaWanitas extends ListRecords
{
    protected static string $resource = KemejaWanitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(KemejaWanitaExporter::class)
                ->icon('heroicon-o-arrow-down-tray'),
            ImportAction::make()
                ->importer(KemejaWanitaImporter::class)
                ->color('primary')
                ->outlined()
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
