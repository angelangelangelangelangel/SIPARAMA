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
        Schema::table('penggiat', function (Blueprint $table) {
            $table->string('jenis_instansi')->nullable()->after('id');
            $table->string('kategori_pendidikan')->nullable()->after('jenis_instansi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penggiat', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_instansi',
                'kategori_pendidikan',
            ]);
        });
    }
};
