<?php

namespace App\Filament\Resources\UkurSeragamResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UkurSeragamResource;

class CreateUkurSeragam extends CreateRecord
{
    protected static string $resource = UkurSeragamResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     dd($data);

    //     return $data;
    // }

    protected function afterCreate(): void
    {
        $this->record->personnel()->update([
            'personel_kelamin' => $this->data['personel_kelamin'],
            'pangkat_nama' => $this->data['pangkat_nama'],
            'satker_nama' => $this->data['satker_nama'],
            'jabatan_nama' => $this->data['jabatan_nama'],
        ]);
    }
}
