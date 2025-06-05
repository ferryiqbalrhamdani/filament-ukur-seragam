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
            'tb' => $this->data['tb'],
            'bb' => $this->data['bb'],
        ]);

        $this->record->histories()->create([
            'ukuran_seragam_id' => $this->record->id,
            'jenis_ukuran' => $this->record->jenis_ukuran,
            'size_pdu' => $this->record->size_pdu,
            'lebar_bahu_pdu' => $this->record->lebar_bahu_pdu,
            'lebar_belakang_pdu' => $this->record->lebar_belakang_pdu,
            'lebar_depan_pdu' => $this->record->lebar_depan_pdu,
            'lebar_dada_pdu' => $this->record->lebar_dada_pdu,
            'lebar_pinggang_pdu' => $this->record->lebar_pinggang_pdu,
            'lebar_bawah_pdu' => $this->record->lebar_bawah_pdu,
            'panjang_baju_pdu' => $this->record->panjang_baju_pdu,
            'panjang_tangan_pdu' => $this->record->panjang_tangan_pdu,
            'lingkar_tangan_atas_pdu' => $this->record->lingkar_tangan_atas_pdu,
            'lingkar_tangan_bawah_pdu' => $this->record->lingkar_tangan_bawah_pdu,

            'size_kemeja' => $this->record->size_kemeja,
            'lebar_bahu_kemeja' => $this->record->lebar_bahu_kemeja,
            'lebar_belakang_kemeja' => $this->record->lebar_belakang_kemeja,
            'lebar_depan_kemeja' => $this->record->lebar_depan_kemeja,
            'lebar_dada_kemeja' => $this->record->lebar_dada_kemeja,
            'lebar_pinggang_kemeja' => $this->record->lebar_pinggang_kemeja,
            'lebar_bawah_kemeja' => $this->record->lebar_bawah_kemeja,
            'panjang_baju_kemeja' => $this->record->panjang_baju_kemeja,
            'panjang_tangan_kemeja' => $this->record->panjang_tangan_kemeja,
            'lingkar_tangan_atas_kemeja' => $this->record->lingkar_tangan_atas_kemeja,
            'lingkar_tangan_bawah_kemeja' => $this->record->lingkar_tangan_bawah_kemeja,

            'size_celana_pdu' => $this->record->size_celana_pdu,
            'lebar_pinggang_celana_pdu' => $this->record->lebar_pinggang_celana_pdu,
            'lebar_pinggul_celana_pdu' => $this->record->lebar_pinggul_celana_pdu,
            'lebar_paha_celana_pdu' => $this->record->lebar_paha_celana_pdu,
            'lebar_lutut_celana_pdu' => $this->record->lebar_lutut_celana_pdu,
            'lebar_bawah_celana_pdu' => $this->record->lebar_bawah_celana_pdu,
            'kress_celana_pdu' => $this->record->kress_celana_pdu,
            'panjang_celana_celana_pdu' => $this->record->panjang_celana_celana_pdu,
        ]);
    }
}
