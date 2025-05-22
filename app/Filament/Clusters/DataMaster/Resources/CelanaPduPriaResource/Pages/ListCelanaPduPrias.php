<?php

namespace App\Filament\Clusters\DataMaster\Resources\CelanaPduPriaResource\Pages;

use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\DataMaster\Resources\CelanaPduPriaResource;
use App\Filament\Exports\CelanaPduPriaExporter;
use App\Filament\Imports\CelanaPduPriaImporter;

class ListCelanaPduPrias extends ListRecords
{
    protected static string $resource = CelanaPduPriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(CelanaPduPriaExporter::class)
                ->icon('heroicon-o-arrow-down-tray'),
            ImportAction::make()
                ->importer(CelanaPduPriaImporter::class)
                ->color('primary')
                ->outlined()
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
