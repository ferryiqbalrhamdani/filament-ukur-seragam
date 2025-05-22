<?php

namespace App\Filament\Imports;

use App\Models\PduWanita;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PduWanitaImporter extends Importer
{
    protected static ?string $model = PduWanita::class;

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

    public function resolveRecord(): ?PduWanita
    {
        // return PduWanita::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new PduWanita();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your pdu wanita import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
