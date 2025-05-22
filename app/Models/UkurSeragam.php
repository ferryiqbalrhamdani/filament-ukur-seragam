<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UkurSeragam extends Model
{
    protected $fillable = [
        'personel_id',
        'jenis_ukuran',

        'size_pdu',
        'lebar_bahu_pdu',
        'lebar_belakang_pdu',
        'lebar_depan_pdu',
        'lebar_dada_pdu',
        'lebar_pinggang_pdu',
        'lebar_bawah_pdu',
        'panjang_baju_pdu',
        'panjang_tangan_pdu',
        'lingkar_tangan_atas_pdu',
        'lingkar_tangan_bawah_pdu',

        'size_kemeja',
        'lebar_bahu_kemeja',
        'lebar_belakang_kemeja',
        'lebar_depan_kemeja',
        'lebar_dada_kemeja',
        'lebar_pinggang_kemeja',
        'lebar_bawah_kemeja',
        'panjang_baju_kemeja',
        'panjang_tangan_kemeja',
        'lingkar_tangan_atas_kemeja',
        'lingkar_tangan_bawah_kemeja',

        'size_celana_pdu',
        'lebar_pinggang_celana_pdu',
        'lebar_pinggul_celana_pdu',
        'lebar_paha_celana_pdu',
        'lebar_lutut_celana_pdu',
        'lebar_bawah_celana_pdu',
        'kress_celana_pdu',
        'panjang_celana_celana_pdu',
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personel_id');
    }


}
