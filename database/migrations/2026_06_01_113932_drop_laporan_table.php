<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('laporan');
    }

    public function down(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_laporan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tanggal_cetak');
            $table->timestamps();
        });
    }
};