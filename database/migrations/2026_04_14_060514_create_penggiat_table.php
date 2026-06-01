<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggiat', function (Blueprint $table) {
    $table->id();
    $table->string('nama_penggiat');
    $table->string('instansi')->nullable();
    $table->string('jabatan')->nullable();
    $table->string('lembaga');
    $table->text('keterangan')->nullable();
    $table->timestamps();
});
    }
    public function down(): void
    {
        Schema::dropIfExists('penggiat');
    }
};