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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('personel_nrp')->nullable();
            $table->string('personel_nama')->nullable();
            $table->string('personel_kelamin')->nullable();
            $table->string('pangkat_nama')->nullable();
            $table->string('satker_nama')->nullable();
            $table->string('jabatan_nama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
