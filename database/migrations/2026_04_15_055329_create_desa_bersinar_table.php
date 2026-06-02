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
        Schema::create('desa_bersinar', function (Blueprint $table) {
            $table->id();

            $table->string('satker');
             $table->string('kab_kota');
            $table->string('nama_desa');

            // DESA /KELURAHAN
            $table->enum('jenis_wilayah', ['Desa', 'Kelurahan']);

            //IKRN
            $table->enum('status_kerawanan', ['Rendah', 'Sedang', 'Tinggi']);

            $table->text('alasan_perhitungan');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desa_bersinar');
    }
};
