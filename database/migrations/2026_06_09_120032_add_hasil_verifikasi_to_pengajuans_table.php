<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {

            $table->string('hasil_verifikasi')
                  ->nullable()
                  ->after('status_verifikasi');

        });
    }

    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {

            $table->dropColumn('hasil_verifikasi');

        });
    }
};