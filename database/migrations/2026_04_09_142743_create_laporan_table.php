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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();

             $table->string('jenis_laporan'); // test urine, penyuluhan, penggiat, desa bersinar
              $table->date('tanggal_mulai');
               $table->date('tanggal_selesai');

                $table->timestamp('tanggal_cetak')->useCurrent();
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
