<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UkuranSeragamHistory extends Model
{
    protected $fillable = [
        'ukuran_seragam_id',
        'jenis_ukuran',

        // PDU
        'size_pdu',
        'lebar_bahu_pdu',
        'lebar_bahu_pdu_toleransi',
        'lebar_belakang_pdu',
        'lebar_belakang_pdu_toleransi',
        'lebar_depan_pdu',
        'lebar_depan_pdu_toleransi',
        'lebar_dada_pdu',
        'lebar_dada_pdu_toleransi',
        'lebar_pinggang_pdu',
        'lebar_pinggang_pdu_toleransi',
        'lebar_bawah_pdu',
        'lebar_bawah_pdu_toleransi',
        'panjang_baju_pdu',
        'panjang_baju_pdu_toleransi',
        'panjang_tangan_pdu',
        'panjang_tangan_pdu_toleransi',
        'lingkar_tangan_atas_pdu',
        'lingkar_tangan_atas_pdu_toleransi',
        'lingkar_tangan_bawah_pdu',
        'lingkar_tangan_bawah_pdu_toleransi',

        // Kemeja
        'size_kemeja',
        'lebar_bahu_kemeja',
        'lebar_bahu_kemeja_toleransi',
        'lebar_belakang_kemeja',
        'lebar_belakang_kemeja_toleransi',
        'lebar_depan_kemeja',
        'lebar_depan_kemeja_toleransi',
        'lebar_dada_kemeja',
        'lebar_dada_kemeja_toleransi',
        'lebar_pinggang_kemeja',
        'lebar_pinggang_kemeja_toleransi',
        'lebar_bawah_kemeja',
        'lebar_bawah_kemeja_toleransi',
        'panjang_baju_kemeja',
        'panjang_baju_kemeja_toleransi',
        'panjang_tangan_kemeja',
        'panjang_tangan_kemeja_toleransi',
        'lingkar_tangan_atas_kemeja',
        'lingkar_tangan_atas_kemeja_toleransi',
        'lingkar_tangan_bawah_kemeja',
        'lingkar_tangan_bawah_kemeja_toleransi',

        // Celana PDU
        'size_celana_pdu',
        'lebar_pinggang_celana_pdu',
        'lebar_pinggang_celana_pdu_toleransi',
        'lebar_pinggul_celana_pdu',
        'lebar_pinggul_celana_pdu_toleransi',
        'lebar_paha_celana_pdu',
        'lebar_paha_celana_pdu_toleransi',
        'lebar_lutut_celana_pdu',
        'lebar_lutut_celana_pdu_toleransi',
        'lebar_bawah_celana_pdu',
        'lebar_bawah_celana_pdu_toleransi',
        'kress_celana_pdu',
        'kress_celana_pdu_toleransi',
        'panjang_celana_celana_pdu',
        'panjang_celana_celana_pdu_toleransi',
    ];

    /**
     * Relasi ke UkurSeragam.
     */
    public function ukuranSeragam()
    {
        return $this->belongsTo(UkurSeragam::class, 'ukuran_seragam_id');
    }
}
