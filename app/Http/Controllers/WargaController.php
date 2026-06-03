<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

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
        return view('warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'provinsi' => 'nullable|string|max:255',
            'nik' => 'required|unique:wargas,nik',
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
        foreach (array_slice(array_values($rows), 1) as $row) {
            $rowValues = array_values($row);
            if (! array_filter($rowValues, fn($value) => trim((string) $value) !== '')) {
                continue;
            }

            $rowData = array_combine($headerRow, array_map(fn($value) => trim((string) $value), $rowValues));
            $nik = $rowData['nik'] ?? null;
            if (! $nik) {
                continue;
            }

            $payload = [
                'provinsi' => $rowData['provinsi'] ?? null,
                'nik' => $nik,
                'nama' => $rowData['nama'] ?? null,
                'tempat_lahir' => $rowData['tempat_lahir'] ?? null,
                'tanggal_lahir' => $this->normalizeDate($rowData['tanggal_lahir'] ?? null),
                'jenis_kelamin' => $rowData['jenis_kelamin'] ?? null,
                'gol_darah' => $rowData['gol_darah'] ?? null,
                'alamat' => $rowData['alamat'] ?? null,
                'kel_desa' => $rowData['kel_desa'] ?? null,
                'kecamatan' => $rowData['kecamatan'] ?? null,
                'agama' => $rowData['agama'] ?? null,
                'status_pernikahan' => $rowData['status_pernikahan'] ?? null,
                'pekerjaan' => $rowData['pekerjaan'] ?? null,
                'kewarganegaraan' => $rowData['kewarganegaraan'] ?? null,
                'penghasilan' => $this->normalizeNumber($rowData['penghasilan'] ?? null),
            ];

            Warga::updateOrCreate([
                'nik' => $nik,
            ], array_filter($payload, fn($value) => $value !== null && $value !== ''));
            $imported++;
        }

        return back()->with('success', "Import berhasil. {$imported} baris diproses.");
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

    private function normalizeDate(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
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
        $warga = Warga::findOrFail($id);

        return view('warga.edit', compact('warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'provinsi' => 'nullable|string|max:255',
            'nik' => 'required|unique:wargas,nik,' . $id,
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
        Warga::destroy($id);

        return redirect()->route('warga.index');
    }

}
// }
