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
        $csvPath = storage_path('app/dataset/warga.csv');

        if (!file_exists($csvPath)) {
            $this->command->error('warga.csv not found at ' . $csvPath);
            return;
        }

        if (($handle = fopen($csvPath, 'r')) === false) {
            $this->command->error('Unable to open warga.csv');
            return;
        }

        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            $this->command->error('warga.csv is empty');
            return;
        }

        while (($row = fgetcsv($handle)) !== false) {
            $row = array_map('trim', $row);
            $data = array_combine($header, $row);

            if (empty($data['nik']) || empty($data['nama']) || !array_key_exists('alamat', $data)) {
                continue;
            }

            Warga::updateOrCreate(
                ['nik' => $data['nik']],
                [
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'],
                ]
            );
        }

        fclose($handle);
    }
}
