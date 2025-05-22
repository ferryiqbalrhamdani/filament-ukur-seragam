<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KemejaPria extends Model
{
    protected $fillable = [
        'size',
        'lebar_bahu',
        'lebar_belakang',
        'lebar_depan',
        'lebar_dada',
        'lebar_pinggang',
        'lebar_bawah',
        'panjang_baju',
        'panjang_tangan',
        'lingkar_tangan_atas',
        'lingkar_tangan_bawah',
    ];
}
