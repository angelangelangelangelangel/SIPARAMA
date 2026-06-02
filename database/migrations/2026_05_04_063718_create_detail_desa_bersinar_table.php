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
        Schema::create('detail_desa_bersinar', function (Blueprint $table) {
            $table->id();

            // RELASI KE DESA
            $table->foreignId('desa_id')
                  ->constrained('desa_bersinar')
                  ->onDelete('cascade');

            $table->string('kegiatan');
            $table->date('tanggal_kegiatan');
             $table->text('keterangan')->nullable();
             
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_desa_bersinar');
    }
};
