<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penyuluhan', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('penyuluhan_id');

            $table->string('jenis_media');
            $table->string('jenis_kegiatan');
            $table->integer('jumlah_paket')->default(0);

            $table->timestamps();

            $table->foreign('penyuluhan_id')
                  ->references('id')
                  ->on('penyuluhan')
                  ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penyuluhan');
    }
};