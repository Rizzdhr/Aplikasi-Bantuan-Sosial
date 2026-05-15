<?php

namespace Database\Seeders;

use App\Models\Warga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WargaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = base_path('dataset/ktp_tabular_v2.csv');

        if (!file_exists($csvPath)) {
            $this->command->error('ktp_tabular_v2.csv not found at ' . $csvPath);
            return;
        }

        if (($handle = fopen($csvPath, 'r')) === false) {
            $this->command->error('Unable to open ktp_tabular_v2.csv');
            return;
        }

        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            $this->command->error('ktp_tabular_v2.csv is empty');
            return;
        }

        while (($row = fgetcsv($handle)) !== false) {
            $row = array_map('trim', $row);
            $data = array_combine($header, $row);

            if (empty($data['nik']) || empty($data['nama'])) {
                continue;
            }

            // Parse tanggal lahir format DD-MM-YYYY to YYYY-MM-DD
            $tanggalLahir = null;
            if (!empty($data['tanggal_lahir'])) {
                try {
                    $tanggalLahir = \DateTime::createFromFormat('d-m-Y', $data['tanggal_lahir'])?->format('Y-m-d');
                } catch (\Exception $e) {
                    $tanggalLahir = null;
                }
            }

            Warga::updateOrCreate(
                ['nik' => $data['nik']],
                [
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'] ?? '',
                    'provinsi' => $data['provinsi'] ?? null,
                    'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
                    'gol_darah' => $data['gol_darah'] ?? null,
                    'kel_desa' => $data['kel_desa'] ?? null,
                    'kecamatan' => $data['kecamatan'] ?? null,
                    'agama' => $data['agama'] ?? null,
                    'status_pernikahan' => $data['status_pernikahan'] ?? null,
                    'pekerjaan' => $data['pekerjaan'] ?? null,
                    'kewarganegaraan' => $data['kewarganegaraan'] ?? null,
                    'tempat_lahir' => $data['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $tanggalLahir,
                ]
            );
        }

        fclose($handle);
    }
}
