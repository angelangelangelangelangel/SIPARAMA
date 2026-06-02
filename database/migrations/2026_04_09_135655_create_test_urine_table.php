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
        Schema::create('test_urine', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal_kegiatan');

            $table->string('nama_instansi');
            $table->string('jenis_instansi');
            $table->string('kategori_pendidikan')->nullable();
            $table->string('sasaran');
            $table->text('tujuan_test');

            // REKAP OTOMATIS
            $table->integer('jumlah_peserta')->default(0);
            $table->integer('jumlah_laki_laki')->default(0);
            $table->integer('jumlah_perempuan')->default(0);
            $table->integer('jumlah_positif')->default(0);
            $table->integer('jumlah_negatif')->default(0);

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_urine');
    }
};