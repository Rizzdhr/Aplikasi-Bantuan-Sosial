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
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi')->nullable();
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('gol_darah')->nullable();
            $table->text('alamat');
            $table->string('kel_desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('agama')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->enum('pekerjaan', [
                // Kelompok 0 — Tidak/belum bekerja
                'BELUM/TIDAK BEKERJA',
                'BELUM BEKERJA',
                'TIDAK BEKERJA',
                'PELAJAR/MAHASISWA',
                'PELAJAR',
                'MAHASISWA',
                'IBU RUMAH TANGGA',
                'PENSIUNAN',
                'PENSIUN',

                // Kelompok 1 — Buruh / pekerja harian
                'BURUH HARIAN LEPAS',
                'BURUH TANI/PERKEBUNAN',
                'BURUH TANI',
                'PERKEBUNAN',
                'BURUH NELAYAN/PERIKANAN',
                'BURUH NELAYAN',
                'PERIKANAN',
                'BURUH PETERNAKAN',
                'PETANI/PEKEBUN',
                'PETANI',
                'PEKEBUN',
                'NELAYAN/PERIKANAN',
                'NELAYAN',
                'PETERNAK',
                'TUKANG BATU',
                'TUKANG KAYU',
                'TUKANG SOL SEPATU',
                'TUKANG CUKUR',
                'TUKANG LAS/PANDAI BESI',
                'TUKANG LAS',
                'PANDAI BESI',
                'TUKANG LISTRIK',
                'TUKANG JAHIT',
                'TUKANG GIGI',
                'MEKANIK',
                'PEMBANTU RUMAH TANGGA',
                'TUKANG OJEK',

                // Kelompok 2 — Pegawai / karyawan
                'KARYAWAN SWASTA',
                'KARYAWAN BUMN',
                'KARYAWAN BUMD',
                'KARYAWAN HONORER',
                'PEGAWAI NEGERI',
                'PEGAWAI SWASTA',
                'TENTARA NASIONAL INDONESIA',
                'KEPOLISIAN RI',
                'PERDAGANGAN',
                'WIRASWASTA',
                'TRANSPORTASI',
                'INDUSTRI',
                'KONSTRUKSI',

                // Kelompok 3 — Profesional / tenaga ahli
                'DOKTER',
                'BIDAN',
                'PERAWAT',
                'APOTEKER',
                'PSIKIATER/PSIKOLOG',
                'PSIKIATER',
                'PSIKOLOG',
                'DOKTER GIGI',
                'GURU/DOSEN',
                'GURU',
                'DOSEN',
                'PENGACARA',
                'NOTARIS',
                'AKUNTAN',
                'KONSULTAN',
                'SENIMAN',
                'WARTAWAN',
                'USTADZ/MUBALIGH',
                'USTADZ',
                'MUBALIGH',
                'PASTOR',
                'PENDETA',
                'POLITIKUS',
                'ANGGOTA DPR-RI',
                'ANGGOTA DPRD',
                'KEPALA DESA',
                'PERANGKAT DESA',
                'PELAUT',
                'PILOT',

                // Kelompok 4 — Pengusaha / pejabat tinggi
                'PENELITI',
                'PEJABAT NEGARA',
                'ANGGOTA BPK',
                'DUTA BESAR',
                'GUBERNUR',
                'BUPATI/WALIKOTA',
                'BUPATI',
                'WALIKOTA',
                'LAINNYA',
            ])->nullable();
            $table->integer('penghasilan')->nullable();
            $table->string('kewarganegaraan')->nullable();
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
