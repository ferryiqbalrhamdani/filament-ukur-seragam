<?php

namespace App\Filament\Exports;

use App\Models\KemejaPria;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class KemejaPriaExporter extends Exporter
{
    protected static ?string $model = KemejaPria::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('size'),
            ExportColumn::make('lebar_bahu'),
            ExportColumn::make('lebar_belakang'),
            ExportColumn::make('lebar_depan'),
            ExportColumn::make('lebar_dada'),
            ExportColumn::make('lebar_pinggang'),
            ExportColumn::make('lebar_bawah'),
            ExportColumn::make('panjang_baju'),
            ExportColumn::make('panjang_tangan'),
            ExportColumn::make('lingkar_tangan_atas'),
            ExportColumn::make('lingkar_tangan_bawah'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your kemeja pria export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
