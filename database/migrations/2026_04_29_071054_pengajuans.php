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

            // Relasi ke warga
            $table->foreignId('warga_id')->constrained()->onDelete('cascade');

            $table->string('pekerjaan');
            $table->integer('penghasilan');
            $table->integer('usia');

            // Upload & AI
            $table->string('foto_rumah');

            // Hasil AI / ML
            $table->string('kondisi_rumah')->nullable();
            $table->float('skor_kelayakan')->nullable();

            // Status
            $table->enum('status', ['diterima', 'ditolak']);

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
