<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_personel', function (Blueprint $table) {
            $table->id();
            $table->string('personel_nrp')->nullable();
            $table->string('personel_nama')->nullable();
            $table->string('pangkat_nama')->nullable();
            $table->string('satker_nama')->nullable();
            $table->string('jabatan_nama')->nullable();
            $table->string('personel_kelamin')->nullable();
            $table->string('kategori')->nullable();
            $table->string('tb')->nullable();
            $table->string('bb')->nullable();
            $table->string('size_jas_pdu_1')->nullable();
            $table->string('size_celana')->nullable();
            $table->string('lingkar_badan_pria')->nullable();
            $table->string('lingkar_badan_wanita')->nullable();
            $table->string('lingkar_pinggang_pria')->nullable();
            $table->string('lingkar_pinggang_wanita')->nullable();
            $table->string('panjang_baju')->nullable();
            $table->string('panjang_tangan')->nullable();
            $table->string('lebar_bahu')->nullable();
            $table->string('size_celana_pdu_1')->nullable();
            $table->string('lingkar_pinggang')->nullable();
            $table->string('lingkar_pinggul')->nullable();
            $table->string('lingkar_paha')->nullable();
            $table->string('panjang_celana')->nullable();
            $table->string('kress')->nullable();
            $table->string('note_1')->nullable();
            $table->string('note_2')->nullable();
            $table->string('custom_pj_tangan')->nullable();
            $table->string('custom_pj_baju')->nullable();
            $table->string('custom_pj_celana')->nullable();
            $table->string('custom_lingkar_pinggang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_personel');
    }
};
