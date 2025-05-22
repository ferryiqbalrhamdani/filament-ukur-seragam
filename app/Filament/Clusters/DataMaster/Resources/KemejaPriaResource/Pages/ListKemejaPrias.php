<?php

namespace App\Filament\Clusters\DataMaster\Resources\KemejaPriaResource\Pages;

use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\DataMaster\Resources\KemejaPriaResource;
use App\Filament\Exports\KemejaPriaExporter;
use App\Filament\Imports\KemejaPriaImporter;

class ListKemejaPrias extends ListRecords
{
    protected static string $resource = KemejaPriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(KemejaPriaExporter::class)
                ->icon('heroicon-o-arrow-down-tray'),
            ImportAction::make()
                ->importer(KemejaPriaImporter::class)
                ->color('primary')
                ->outlined()
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
