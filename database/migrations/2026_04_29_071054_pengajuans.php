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

            // Bantuan
            $table->enum('program_bantuan', ['kip', 'jkn', 'pkh', 'bpnt', 'blt']);

            // Input manual
            $table->integer('penghasilan');
            $table->integer('usia');

            // Upload & AI
            $table->string('foto_rumah');

            $table->enum('pekerjaan', ['tidak_bekerja','buruh_harian', 'pegawai/karyawan']);

            // Hasil AI / ML
            $table->string('kondisi_rumah')->nullable(); // buruk/sedang/baik
            $table->float('skor_kelayakan')->nullable();

            // Status
            $table->enum('status', ['pending', 'diproses', 'diterima', 'ditolak'])->default('pending');

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
