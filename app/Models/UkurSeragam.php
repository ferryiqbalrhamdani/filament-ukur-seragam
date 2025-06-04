<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UkurSeragam extends Model
{
    protected $fillable = [
        'personel_id',
        'jenis_ukuran',
        'jenis_ukuran_kemeja',
        'jenis_ukuran_celana_pdu',

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

        'toleransi_lebar_bahu_pdu',
        'toleransi_lebar_belakang_pdu',
        'toleransi_lebar_depan_pdu',
        'toleransi_lebar_dada_pdu',
        'toleransi_lebar_pinggang_pdu',
        'toleransi_lebar_bawah_pdu',
        'toleransi_panjang_baju_pdu',
        'toleransi_panjang_tangan_pdu',
        'toleransi_lingkar_tangan_atas_pdu',
        'toleransi_lingkar_tangan_bawah_pdu',

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

        'toleransi_lebar_bahu_kemeja',
        'toleransi_lebar_belakang_kemeja',
        'toleransi_lebar_depan_kemeja',
        'toleransi_lebar_dada_kemeja',
        'toleransi_lebar_pinggang_kemeja',
        'toleransi_lebar_bawah_kemeja',
        'toleransi_panjang_baju_kemeja',
        'toleransi_panjang_tangan_kemeja',
        'toleransi_lingkar_tangan_atas_kemeja',
        'toleransi_lingkar_tangan_bawah_kemeja',

        'size_celana_pdu',
        'lebar_pinggang_celana_pdu',
        'lebar_pinggul_celana_pdu',
        'lebar_paha_celana_pdu',
        'lebar_lutut_celana_pdu',
        'lebar_bawah_celana_pdu',
        'kress_celana_pdu',
        'panjang_celana_celana_pdu',

        'toleransi_lebar_pinggang_celana_pdu',
        'toleransi_lebar_pinggul_celana_pdu',
        'toleransi_lebar_paha_celana_pdu',
        'toleransi_lebar_lutut_celana_pdu',
        'toleransi_lebar_bawah_celana_pdu',
        'toleransi_kress_celana_pdu',
        'toleransi_panjang_celana_celana_pdu',
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personel_id');
    }

    public function histories()
    {
        return $this->hasMany(UkuranSeragamHistory::class, 'ukuran_seragam_id');
    }
}
