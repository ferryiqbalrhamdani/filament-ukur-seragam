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
        Schema::create('celana_pdu_prias', function (Blueprint $table) {
            $table->id();
            $table->string('size', 100)->nullable();
            $table->float('lebar_pinggang')->nullable();
            $table->float('lebar_pinggul')->nullable();
            $table->float('lebar_paha')->nullable();
            $table->float('lebar_lutut')->nullable();
            $table->float('lebar_bawah')->nullable();
            $table->float('kress')->nullable();
            $table->float('panjang_celana')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celana_pdu_prias');
    }
};
