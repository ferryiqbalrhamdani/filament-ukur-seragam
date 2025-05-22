<?php

namespace App\Filament\Imports;

use App\Models\CelanaPduPria;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CelanaPduPriaImporter extends Importer
{
    protected static ?string $model = CelanaPduPria::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('size')
                ->rules(['max:100']),
            ImportColumn::make('lebar_pinggang')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('lebar_pinggul')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('lebar_paha')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('lebar_lutut')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('lebar_bawah')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('kress')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('panjang_celana')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?CelanaPduPria
    {
        // return CelanaPduPria::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new CelanaPduPria();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your celana pdu pria import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
