<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_urine', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('nama_instansi');
        });
    }

    public function down(): void
    {
        Schema::table('test_urine', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};