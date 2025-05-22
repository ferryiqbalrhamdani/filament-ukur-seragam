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
        Schema::create('kemeja_prias', function (Blueprint $table) {
            $table->id();
            $table->string('size', 100)->nullable();
            $table->float('lebar_bahu')->nullable();
            $table->float('lebar_belakang')->nullable();
            $table->float('lebar_depan')->nullable();
            $table->float('lebar_dada')->nullable();
            $table->float('lebar_pinggang')->nullable();
            $table->float('lebar_bawah')->nullable();
            $table->float('panjang_baju')->nullable();
            $table->float('panjang_tangan')->nullable();
            $table->float('lingkar_tangan_atas')->nullable();
            $table->float('lingkar_tangan_bawah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kemeja_prias');
    }
};
