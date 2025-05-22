<?php

namespace App\Filament\Imports;

use App\Models\PduPria;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PduPriaImporter extends Importer
{
    protected static ?string $model = PduPria::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('size')
                ->rules(['max:100']),
            ImportColumn::make('lebar_bahu')
                ->numeric(),
            ImportColumn::make('lebar_belakang')
                ->numeric(),
            ImportColumn::make('lebar_depan')
                ->numeric(),
            ImportColumn::make('lebar_dada')
                ->numeric(),
            ImportColumn::make('lebar_pinggang')
                ->numeric(),
            ImportColumn::make('lebar_bawah')
                ->numeric(),
            ImportColumn::make('panjang_baju')
                ->numeric(),
            ImportColumn::make('panjang_tangan')
                ->numeric(),
            ImportColumn::make('lingkar_tangan_atas')
                ->numeric(),
            ImportColumn::make('lingkar_tangan_bawah')
                ->numeric(),
        ];
    }

    public function resolveRecord(): ?PduPria
    {
        // return PduPria::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new PduPria();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your pdu pria import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
