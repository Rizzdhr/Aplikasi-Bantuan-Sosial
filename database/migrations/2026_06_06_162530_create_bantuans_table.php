<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bantuans', function (Blueprint $table) {
            $table->id();

            $table->string('nama_bantuan');

            $table->text('deskripsi')->nullable();

            $table->decimal('nominal', 15, 2)->nullable();

            $table->date('tanggal_mulai');

            $table->date('tanggal_selesai');

            $table->enum('status', [
                'aktif',
                'selesai'
            ])->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bantuans');
    }
};