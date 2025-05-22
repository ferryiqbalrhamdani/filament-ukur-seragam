<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $fillable = [
        'personel_nrp',
        'personel_nama',
        'personel_kelamin',
        'pangkat_nama',
        'satker_nama',
        'jabatan_nama',
    ];
}
