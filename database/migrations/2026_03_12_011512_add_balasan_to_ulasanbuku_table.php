<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ulasanbuku', function (Blueprint $table) {
            // Menambahkan kolom Balasan (boleh kosong / nullable)
            $table->text('Balasan')->nullable()->after('Rating');
        });
    }

    public function down(): void
    {
        Schema::table('ulasanbuku', function (Blueprint $table) {
            $table->dropColumn('Balasan');
        });
    }
};