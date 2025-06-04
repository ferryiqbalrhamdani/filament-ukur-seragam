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

    public function ukurSeragam()
    {
        return $this->hasMany(UkurSeragam::class, 'personel_id');
    }

    public function latestUkurSeragam()
    {
        return $this->hasOne(UkurSeragam::class, 'personel_id');
    }
}
