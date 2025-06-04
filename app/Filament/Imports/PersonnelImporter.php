<?php

namespace App\Filament\Imports;

use App\Models\Personnel;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PersonnelImporter extends Importer
{
    protected static ?string $model = Personnel::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('personel_nrp'),
            ImportColumn::make('personel_nama'),
            ImportColumn::make('personel_kelamin'),
            ImportColumn::make('tb'),
            ImportColumn::make('bb'),
            ImportColumn::make('pangkat_nama'),
            ImportColumn::make('satker_nama'),
            ImportColumn::make('jabatan_nama'),
        ];
    }

    public function resolveRecord(): ?Personnel
    {
        return Personnel::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'personel_nrp' => $this->data['personel_nrp'],
        ]);

        // return new Personnel();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your personnel import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
