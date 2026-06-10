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
        Schema::table('penerima_bantuans', function (Blueprint $table) {
            Schema::table('penerima_bantuans', function ($table) {
             $table->timestamp('tanggal_terima')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penerima_bantuans', function (Blueprint $table) {
            //
        });
    }
};
