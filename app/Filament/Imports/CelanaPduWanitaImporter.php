<?php

namespace App\Filament\Imports;

use App\Models\CelanaPduWanita;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CelanaPduWanitaImporter extends Importer
{
    protected static ?string $model = CelanaPduWanita::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('size')
                ->rules(['max:100']),
            ImportColumn::make('lebar_pinggang')
                ->numeric(),
            ImportColumn::make('lebar_pinggul')
                ->numeric(),
            ImportColumn::make('lebar_paha')
                ->numeric(),
            ImportColumn::make('lebar_lutut')
                ->numeric(),
            ImportColumn::make('lebar_bawah')
                ->numeric(),
            ImportColumn::make('kress')
                ->numeric(),
            ImportColumn::make('panjang_celana')
                ->numeric(),
        ];
    }

    public function resolveRecord(): ?CelanaPduWanita
    {
        // return CelanaPduWanita::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new CelanaPduWanita();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your celana pdu wanita import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
