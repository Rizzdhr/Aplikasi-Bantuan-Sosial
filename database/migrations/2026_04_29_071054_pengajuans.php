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
    Schema::create('pengajuans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('warga_id')->constrained()->onDelete('cascade');
        $table->string('jenis_bantuan');
        $table->text('keterangan')->nullable();
        $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
