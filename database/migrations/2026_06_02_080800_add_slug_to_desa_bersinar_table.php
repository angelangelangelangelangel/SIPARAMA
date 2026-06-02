<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('desa_bersinar', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('nama_desa');
        });
    }

    public function down(): void
    {
        Schema::table('desa_bersinar', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};