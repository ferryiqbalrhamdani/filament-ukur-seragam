<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CelanaPduWanita extends Model
{
    protected $fillable = [
        'size',
        'lebar_pinggang',
        'lebar_pinggul',
        'lebar_paha',
        'lebar_lutut',
        'lebar_bawah',
        'kress',
        'panjang_celana',
    ];
}
