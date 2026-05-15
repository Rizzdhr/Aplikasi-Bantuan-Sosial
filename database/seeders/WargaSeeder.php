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

            if (empty($data['NIK']) || empty($data['Nama'])) {
                continue;
            }

            // Parse tanggal lahir format DD-MM-YYYY to YYYY-MM-DD
            $tanggalLahir = null;
            if (!empty($data['Tanggal-Lahir'])) {
                try {
                    $tanggalLahir = \DateTime::createFromFormat('d-m-Y', $data['Tanggal-Lahir'])?->format('Y-m-d');
                } catch (\Exception $e) {
                    $tanggalLahir = null;
                }
            }

            Warga::updateOrCreate(
                ['nik' => $data['NIK']],
                [
                    'nama' => $data['Nama'],
                    'alamat' => $data['Alamat'] ?? '',
                    'provinsi' => $data['Provinsi'] ?? null,
                    'jenis_kelamin' => $data['Jenis-Kelamin'] ?? null,
                    'gol_darah' => $data['Gol-Darah'] ?? null,
                    'kel_desa' => $data['Kel/Desa'] ?? null,
                    'kecamatan' => $data['Kecamatan'] ?? null,
                    'agama' => $data['Agama'] ?? null,
                    'status_pernikahan' => $data['Status-Pernikahan'] ?? null,
                    'pekerjaan' => $data['Pekerjaan'] ?? null,
                    'kewarganegaraan' => $data['Kewarganegaraan'] ?? null,
                    'tempat_lahir' => $data['Tempat-Lahir'] ?? null,
                    'tanggal_lahir' => $tanggalLahir,
                ]
            );
        }

        fclose($handle);
    }
}
