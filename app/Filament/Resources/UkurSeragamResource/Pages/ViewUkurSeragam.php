<?php

namespace App\Filament\Resources\UkurSeragamResource\Pages;

use Filament\Actions;
use Illuminate\Support\Js;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\UkurSeragamResource;

class ViewUkurSeragam extends ViewRecord
{
    protected static string $resource = UkurSeragamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kembali')
                ->label("kembali")
                ->alpineClickHandler('document.referrer ? window.history.back() : (window.location.href = ' . Js::from($this->previousUrl ?? static::getResource()::getUrl()) . ')')
                ->color('gray')
                ->icon('heroicon-o-arrow-left'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $personel = \App\Models\Personnel::find($data['personel_id'] ?? null);

        if ($personel) {
            $data['personel_nama'] = $personel->personel_nama;
            $data['personel_kelamin'] = $personel->personel_kelamin;
            $data['pangkat_nama'] = $personel->pangkat_nama;
            $data['satker_nama'] = $personel->satker_nama;
            $data['jabatan_nama'] = $personel->jabatan_nama;
            $data['tb'] = $personel->tb;
            $data['bb'] = $personel->bb;
        }

        return $data;
    }
}
