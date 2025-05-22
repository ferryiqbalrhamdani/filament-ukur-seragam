<?php

namespace App\Filament\Exports;

use App\Models\CelanaPduWanita;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CelanaPduWanitaExporter extends Exporter
{
    protected static ?string $model = CelanaPduWanita::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('size'),
            ExportColumn::make('lebar_pinggang'),
            ExportColumn::make('lebar_pinggul'),
            ExportColumn::make('lebar_paha'),
            ExportColumn::make('lebar_lutut'),
            ExportColumn::make('lebar_bawah'),
            ExportColumn::make('kress'),
            ExportColumn::make('panjang_celana'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your celana pdu wanita export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
