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
        Schema::create('peserta_test_urine', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_urine_id')
                  ->constrained('test_urine')
                  ->onDelete('cascade');

            $table->string('nama_peserta');

            $table->enum('jenis_kelamin', ['L', 'P']);

            //  status kehadiran
            $table->enum('status_kehadiran', ['hadir', 'tidak hadir'])->nullable();

            //  hasil test
            $table->enum('hasil', ['reaktif', 'non_reaktif'])->nullable();

           
            $table->text('riwayat_obat')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_test_urine');
    }
};