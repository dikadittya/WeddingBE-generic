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
        Schema::create('data_alamat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alamat')->unique();
            $table->string('nama_provinsi');
            $table->string('kode_provinsi');
            $table->string('nama_kabupaten');
            $table->string('kode_kabupaten');
            $table->string('nama_kecamatan');
            $table->string('kode_kecamatan');
            $table->string('nama_desa');
            $table->string('kode_desa');
            $table->decimal('jarak', 8, 2)->nullable(); // Distance in kilometers
            $table->string('kd_rumahan')->nullable(); // Residential code
            $table->string('kd_gedung')->nullable(); // Building code
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_alamat');
    }
};
