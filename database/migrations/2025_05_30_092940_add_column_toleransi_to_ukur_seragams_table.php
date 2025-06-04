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
        Schema::table('ukur_seragams', function (Blueprint $table) {
            $table->string('jenis_ukuran_kemeja', 100)->nullable()->default('text');
            $table->string('jenis_ukuran_celana_pdu', 100)->nullable()->default('text');

            $table->float('toleransi_lebar_bahu_pdu')->default(0);
            $table->float('toleransi_lebar_belakang_pdu')->default(0);
            $table->float('toleransi_lebar_depan_pdu')->default(0);
            $table->float('toleransi_lebar_dada_pdu')->default(0);
            $table->float('toleransi_lebar_pinggang_pdu')->default(0);
            $table->float('toleransi_lebar_bawah_pdu')->default(0);
            $table->float('toleransi_panjang_baju_pdu')->default(0);
            $table->float('toleransi_panjang_tangan_pdu')->default(0);
            $table->float('toleransi_lingkar_tangan_atas_pdu')->default(0);
            $table->float('toleransi_lingkar_tangan_bawah_pdu')->default(0);

            $table->float('toleransi_lebar_bahu_kemeja')->default(0);
            $table->float('toleransi_lebar_belakang_kemeja')->default(0);
            $table->float('toleransi_lebar_depan_kemeja')->default(0);
            $table->float('toleransi_lebar_dada_kemeja')->default(0);
            $table->float('toleransi_lebar_pinggang_kemeja')->default(0);
            $table->float('toleransi_lebar_bawah_kemeja')->default(0);
            $table->float('toleransi_panjang_baju_kemeja')->default(0);
            $table->float('toleransi_panjang_tangan_kemeja')->default(0);
            $table->float('toleransi_lingkar_tangan_atas_kemeja')->default(0);
            $table->float('toleransi_lingkar_tangan_bawah_kemeja')->default(0);

            $table->float('toleransi_lebar_pinggang_celana_pdu')->default(0);
            $table->float('toleransi_lebar_pinggul_celana_pdu')->default(0);
            $table->float('toleransi_lebar_paha_celana_pdu')->default(0);
            $table->float('toleransi_lebar_lutut_celana_pdu')->default(0);
            $table->float('toleransi_lebar_bawah_celana_pdu')->default(0);
            $table->float('toleransi_kress_celana_pdu')->default(0);
            $table->float('toleransi_panjang_celana_celana_pdu')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ukur_seragams', function (Blueprint $table) {
            $table->dropColumn([
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

                'toleransi_lebar_pinggang_celana_pdu',
                'toleransi_lebar_pinggul_celana_pdu',
                'toleransi_lebar_paha_celana_pdu',
                'toleransi_lebar_lutut_celana_pdu',
                'toleransi_lebar_bawah_celana_pdu',
                'toleransi_kress_celana_pdu',
                'toleransi_panjang_celana_celana_pdu',
            ]);
        });
    }
};
