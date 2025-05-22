<?php

namespace App\Filament\Clusters\DataMaster\Resources\PduWanitaResource\Pages;

use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Exports\PduWanitaExporter;
use App\Filament\Clusters\DataMaster\Resources\PduWanitaResource;
use App\Filament\Imports\PduWanitaImporter;

class ListPduWanitas extends ListRecords
{
    protected static string $resource = PduWanitaResource::class;

    protected static ?string $title = 'PDU Wanita';


    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(PduWanitaExporter::class)
                ->icon('heroicon-o-arrow-down-tray'),
            ImportAction::make()
                ->importer(PduWanitaImporter::class)
                ->color('primary')
                ->outlined()
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
