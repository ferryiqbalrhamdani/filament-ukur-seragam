<?php

namespace App\Filament\Clusters\DataMaster\Resources\PduPriaResource\Pages;

use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\DataMaster\Resources\PduPriaResource;
use App\Filament\Exports\PduPriaExporter;
use App\Filament\Imports\PduPriaImporter;

class ListPduPrias extends ListRecords
{
    protected static string $resource = PduPriaResource::class;

    protected static ?string $title = 'PDU Pria';

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(PduPriaExporter::class)
                ->icon('heroicon-o-arrow-down-tray'),
            ImportAction::make()
                ->importer(PduPriaImporter::class)
                ->color('primary')
                ->outlined()
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
