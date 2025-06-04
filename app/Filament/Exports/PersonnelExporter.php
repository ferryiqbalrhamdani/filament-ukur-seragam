<?php

namespace App\Filament\Exports;

use App\Models\Personnel;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PersonnelExporter extends Exporter
{
    protected static ?string $model = Personnel::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('personel_nrp'),
            ExportColumn::make('personel_nama'),
            ExportColumn::make('personel_kelamin'),
            ExportColumn::make('tb'),
            ExportColumn::make('bb'),
            ExportColumn::make('pangkat_nama'),
            ExportColumn::make('satker_nama'),
            ExportColumn::make('jabatan_nama'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your personnel export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
