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
    Schema::create('penerima_bantuans', function (Blueprint $table) {
        $table->id();

        $table->foreignId('warga_id')
            ->constrained()
            ->onDelete('cascade');

        $table->foreignId('bantuan_id')
            ->constrained()
            ->onDelete('cascade');

        $table->enum('status', [
        'belum_menerima',
        'sudah_menerima'
    ])->default('belum_menerima');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuans');
    }
};
