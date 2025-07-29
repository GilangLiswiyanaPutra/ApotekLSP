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
        Schema::table('detail_penjualans', function (Blueprint $table) {
            // Change kode_obat column from integer to string
            $table->string('kode_obat')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_penjualans', function (Blueprint $table) {
            // Revert kode_obat column back to integer
            $table->integer('kode_obat')->change();
        });
    }
};
