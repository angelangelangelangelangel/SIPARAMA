<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyuluhan', function (Blueprint $table) {

            $table->id();

            $table->date('tanggal_kegiatan');
            $table->string('nama_tempat');

            $table->string('jenis_instansi')->nullable();
            $table->string('kategori_pendidikan')->nullable();
            $table->string('sasaran')->nullable();

            $table->integer('jumlah_sebaran')->default(0);

            $table->string('keterangan')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyuluhan');
    }
};