<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\User;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $search = $request->search;

    $wargas = Warga::when($search, function ($query) use ($search) {
        $query->where('nik', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%");
    })->paginate(10);

    return view('warga.index', compact('wargas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Akses ditolak.');

        return view('warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Akses ditolak.');

        $request->validate([
            'provinsi' => 'nullable|string|max:255',
            'nik' => 'required|digits:16|unique:wargas,nik',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'nullable|string|max:100',
            'gol_darah' => 'nullable|string|max:10',
            'alamat' => 'required|string',
            'kel_desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'penghasilan' => 'required|integer|min:0',
        ]);

        Warga::create($request->only([
            'provinsi',
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'gol_darah',
            'alamat',
            'kel_desa',
            'kecamatan',
            'agama',
            'status_pernikahan',
            'pekerjaan',
            'kewarganegaraan',
            'penghasilan',
        ]));

        return redirect()
            ->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan');
    }

    /**
     * Import data warga from CSV or Excel.
     */
    public function import(Request $request)
    {
        set_time_limit(300);

        abort_unless(auth()->user()->isAdmin(), 403, 'Akses ditolak.');

        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt,xls,xlsx',
        ]);

        $file = $request->file('import_file');
        $extension = strtolower($file->getClientOriginalExtension());
        $rows = [];

        if (in_array($extension, ['xls', 'xlsx']) && class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        } elseif (in_array($extension, ['csv', 'txt'])) {
            $rows = $this->readCsvFile($file->getRealPath());
        } else {
            return back()->with('error', 'Format file tidak didukung. Gunakan CSV atau XLSX.');
        }

        if (count($rows) < 2) {
            return back()->with('error', 'File import kosong atau tidak memiliki header.');
        }
        

        $firstRow = reset($rows);
        if ($firstRow === false || !is_array($firstRow)) {
            return back()->with('error', 'File import kosong atau tidak memiliki header.');
        }

        $headerRow = array_map(fn($h) => strtolower(trim((string) $h)), array_values($firstRow));
        $requiredColumns = ['nik', 'nama'];
        foreach ($requiredColumns as $requiredColumn) {
            if (! in_array($requiredColumn, $headerRow, true)) {
                return back()->with('error', "Header \"{$requiredColumn}\" tidak ditemukan di file import.");
            }
        }

        $imported = 0;
        $skipped = 0;
        $errors = [];
        $defaultPassword = bcrypt('123456');

        foreach (array_slice(array_values($rows), 1) as $index => $row) {
            $rowValues = array_values($row);
            if (! array_filter($rowValues, fn($value) => trim((string) $value) !== '')) {
                continue;
            }

            $rowData = array_combine($headerRow, array_map(fn($value) => trim((string) $value), $rowValues));
            $nik = preg_replace('/\D/', '', $rowData['nik'] ?? ''); // bersihkan non-angka

            // Validasi NIK kosong
            if (!$nik) {
                $errors[] = "Baris " . ($index + 2) . ": NIK kosong, dilewati.";
                $skipped++;
                continue;
            }

            // Validasi NIK harus 16 digit
            if (strlen($nik) !== 16) {
                $errors[] = "Baris " . ($index + 2) . ": NIK '{$nik}' tidak 16 digit, dilewati.";
                $skipped++;
                continue;
            }

            // Cek NIK sudah ada
            $exists = Warga::where('nik', $nik)->exists();
            if ($exists) {
                $errors[] = "Baris " . ($index + 2) . ": NIK '{$nik}' sudah terdaftar, dilewati.";
                $skipped++;
                continue;
            }

              $payload = [
                    'provinsi'          => $rowData['provinsi'] ?? null,
                    'nik'               => $nik,
                    'nama'              => $rowData['nama'] ?? null,
                    'tempat_lahir'      => $rowData['tempat_lahir'] ?? null,
                    'tanggal_lahir'     => $this->normalizeDate($rowData['tanggal_lahir'] ?? null),
                    'jenis_kelamin'     => $rowData['jenis_kelamin'] ?? null,
                    'gol_darah'         => $rowData['gol_darah'] ?? null,
                    'alamat'            => $rowData['alamat'] ?? null,
                    'kel_desa'          => $rowData['kel_desa'] ?? null,
                    'kecamatan'         => $rowData['kecamatan'] ?? null,
                    'agama'             => $rowData['agama'] ?? null,
                    'status_pernikahan' => $rowData['status_pernikahan'] ?? null,
                    'pekerjaan'         => $rowData['pekerjaan'] ?? null,
                    'kewarganegaraan'   => $rowData['kewarganegaraan'] ?? null,
                    'penghasilan'       => $this->normalizeNumber($rowData['penghasilan'] ?? null),
                    'email'             => $rowData['email'] ?? null,
                ];

                $warga = Warga::create(
            array_filter($payload, fn($value) => $value !== null && $value !== '')
        );

        // Buat akun warga otomatis jika email ada di dataset
        if (!empty($rowData['email'])) {

           User::firstOrCreate(
            [
                'email' => $rowData['email']
            ],
            [
                'name' => $rowData['nama'],
                'password' => Hash::make($nik),
                'role' => 'warga',
                'warga_id' => $warga->id,
          
            ]
        
        );
        }

        $imported++;
        }

        // Susun pesan hasil import
        $message = "Import selesai. {$imported} baris berhasil diimpor.";
        if ($skipped > 0) {
            $message .= " {$skipped} baris dilewati.";
        }

        // Simpan detail error ke session jika ada
        if (!empty($errors)) {
            return back()
                ->with('success', $message)
                ->with('import_errors', $errors);
        }

        return back()->with('success', $message);
    }

    private function readCsvFile(string $path): array
{
    $rows = [];
    if (($handle = fopen($path, 'r')) !== false) {
        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $rows[] = $row;
        }
        fclose($handle);
    }
    return $rows;
}
    private function normalizeDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            // Jika berupa serial date Excel
            if (is_numeric($value)) {
                return ExcelDate::excelToDateTimeObject($value)
                    ->format('Y-m-d');
            }

            return Carbon::parse($value)
                ->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function normalizeNumber(?string $value): ?int
    {
        if ($value === null) {
            return null;
        }

        $cleaned = preg_replace('/[^0-9-]/', '', $value);
        return $cleaned === '' ? null : (int) $cleaned;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $warga = Warga::findOrFail($id);
        $qrCode = $this->makeQrCodeDataUri($warga->nik);

        return view('warga.show', compact('warga', 'qrCode'));
    }

    /**
     * Download the QR code image for the specified resource.
     */
    public function downloadQr(Warga $warga)
    {
        $qrResult = Builder::create()
            ->writer(new PngWriter())
            ->data($warga->nik)
            ->size(300)
            ->margin(10)
            ->build();

        $fileName = "warga-{$warga->nik}-qr.png";

        return response($qrResult->getString(), 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    private function makeQrCodeDataUri(string $payload): string
    {
        return Builder::create()
            ->writer(new PngWriter())
            ->data($payload)
            ->size(300)
            ->margin(10)
            ->build()
            ->getDataUri();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Akses ditolak.');

        $warga = Warga::findOrFail($id);

        return view('warga.edit', compact('warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Akses ditolak.');

        $request->validate([
            'provinsi' => 'nullable|string|max:255',
            'nik' => 'required|digits:16|unique:wargas,nik,' . $id,
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'nullable|string|max:100',
            'gol_darah' => 'nullable|string|max:10',
            'alamat' => 'required|string',
            'kel_desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'penghasilan' => 'required|integer|min:0',
        ]);

        $warga = Warga::findOrFail($id);

        $warga->update($request->only([
            'provinsi',
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'gol_darah',
            'alamat',
            'kel_desa',
            'kecamatan',
            'agama',
            'status_pernikahan',
            'pekerjaan',
            'kewarganegaraan',
            'penghasilan',
        ]));

        return redirect()
            ->route('warga.index')
            ->with('success', 'Data warga berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Akses ditolak.');

        Warga::destroy($id);

        return redirect()->route('warga.index');
    }

}
// }
