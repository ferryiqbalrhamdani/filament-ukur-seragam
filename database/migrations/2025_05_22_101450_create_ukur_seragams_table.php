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
        Schema::create('ukur_seragams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personel_id')->constrained('personnels')->onDelete('cascade');
            $table->string('jenis_ukuran')->nullable();

            $table->string('size_pdu', 100)->nullable();
            $table->float('lebar_bahu_pdu')->nullable();
            $table->float('lebar_belakang_pdu')->nullable();
            $table->float('lebar_depan_pdu')->nullable();
            $table->float('lebar_dada_pdu')->nullable();
            $table->float('lebar_pinggang_pdu')->nullable();
            $table->float('lebar_bawah_pdu')->nullable();
            $table->float('panjang_baju_pdu')->nullable();
            $table->float('panjang_tangan_pdu')->nullable();
            $table->float('lingkar_tangan_atas_pdu')->nullable();
            $table->float('lingkar_tangan_bawah_pdu')->nullable();

            $table->string('size_kemeja', 100)->nullable();
            $table->float('lebar_bahu_kemeja')->nullable();
            $table->float('lebar_belakang_kemeja')->nullable();
            $table->float('lebar_depan_kemeja')->nullable();
            $table->float('lebar_dada_kemeja')->nullable();
            $table->float('lebar_pinggang_kemeja')->nullable();
            $table->float('lebar_bawah_kemeja')->nullable();
            $table->float('panjang_baju_kemeja')->nullable();
            $table->float('panjang_tangan_kemeja')->nullable();
            $table->float('lingkar_tangan_atas_kemeja')->nullable();
            $table->float('lingkar_tangan_bawah_kemeja')->nullable();

            $table->string('size_celana_pdu', 100)->nullable();
            $table->float('lebar_pinggang_celana_pdu')->nullable();
            $table->float('lebar_pinggul_celana_pdu')->nullable();
            $table->float('lebar_paha_celana_pdu')->nullable();
            $table->float('lebar_lutut_celana_pdu')->nullable();
            $table->float('lebar_bawah_celana_pdu')->nullable();
            $table->float('kress_celana_pdu')->nullable();
            $table->float('panjang_celana_celana_pdu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukur_seragams');
    }
};
