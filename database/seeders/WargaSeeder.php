<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('app/dataset/ktp_tabular_v2.csv');

        if (!file_exists($path)) {
            $this->command->error('File CSV tidak ditemukan: ' . $path);
            return;
        }

        $file = fopen($path, 'r');

        // Skip header
        $header = fgetcsv($file);

        $batch = [];
        $count = 0;

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < count($header)) continue;

            $data = array_combine($header, $row);

            $batch[] = [
                'provinsi'          => $data['provinsi'] ?? null,
                'nik'               => $data['nik'] ?? null,
                'nama'              => $data['nama'] ?? null,
                'jenis_kelamin'     => $data['jenis_kelamin'] ?? null,
                'gol_darah'         => $data['gol_darah'] ?? null,
                'alamat'            => $data['alamat'] ?? null,
                'kel_desa'          => $data['kel_desa'] ?? null,
                'kecamatan'         => $data['kecamatan'] ?? null,
                'agama'             => $data['agama'] ?? null,
                'status_pernikahan' => $data['status_pernikahan'] ?? null,
                'pekerjaan'         => $data['pekerjaan'] ?? null,
                'kewarganegaraan'   => $data['kewarganegaraan'] ?? null,
                'tempat_lahir'      => $data['tempat_lahir'] ?? null,
                'tanggal_lahir'     => !empty($data['tanggal_lahir'])
                                        ? Carbon::parse($data['tanggal_lahir'])->format('Y-m-d')
                                        : null,
                'penghasilan'       => !empty($data['penghasilan'])
                                        ? (int) $data['penghasilan']
                                        : 0,
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            // Insert per 500 baris agar tidak habis memory
            if (count($batch) >= 500) {
                DB::table('wargas')->insertOrIgnore($batch);
                $count += count($batch);
                $batch = [];
                $this->command->info("Inserted: $count rows...");
            }
        }

        // Insert sisa
        if (!empty($batch)) {
            DB::table('wargas')->insertOrIgnore($batch);
            $count += count($batch);
        }

        fclose($file);

        $this->command->info("Selesai. Total: $count warga dimasukkan.");
    }
}
