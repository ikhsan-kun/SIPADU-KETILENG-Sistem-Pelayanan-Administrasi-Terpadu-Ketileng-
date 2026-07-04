<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PendudukImport;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.penduduk.index');
    }

    public function create()
    {
        return view('admin.penduduk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'               => ['required', 'digits:16', 'unique:penduduk,nik'],
            'no_kk'             => ['required', 'digits:16'],
            'nama'              => ['required', 'string', 'max:100'],
            'tempat_lahir'      => ['required', 'string', 'max:50'],
            'tanggal_lahir'     => ['required', 'date'],
            'jenis_kelamin'     => ['required', 'in:Laki-laki,Perempuan'],
            'alamat'            => ['required', 'string'],
            'rt'                => ['nullable', 'string', 'max:5'],
            'rw'                => ['nullable', 'string', 'max:5'],
            'desa'              => ['required', 'string', 'max:50'],
            'kecamatan'         => ['required', 'string', 'max:50'],
            'agama'             => ['nullable', 'string', 'max:20'],
            'pekerjaan'         => ['nullable', 'string', 'max:50'],
            'status_perkawinan' => ['required', 'in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati'],
            'kewarganegaraan'   => ['required', 'string', 'max:50'],
        ]);

        Penduduk::create($validated);

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik'               => ['required', 'digits:16', "unique:penduduk,nik,{$penduduk->id}"],
            'no_kk'             => ['required', 'digits:16'],
            'nama'              => ['required', 'string', 'max:100'],
            'tempat_lahir'      => ['required', 'string', 'max:50'],
            'tanggal_lahir'     => ['required', 'date'],
            'jenis_kelamin'     => ['required', 'in:Laki-laki,Perempuan'],
            'alamat'            => ['required', 'string'],
            'rt'                => ['nullable', 'string', 'max:5'],
            'rw'                => ['nullable', 'string', 'max:5'],
            'desa'              => ['required', 'string', 'max:50'],
            'kecamatan'         => ['required', 'string', 'max:50'],
            'agama'             => ['nullable', 'string', 'max:20'],
            'pekerjaan'         => ['nullable', 'string', 'max:50'],
            'status_perkawinan' => ['required', 'in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati'],
            'kewarganegaraan'   => ['required', 'string', 'max:50'],
        ]);

        $penduduk->update($validated);

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    /**
     * Import data penduduk dari file Excel (.xlsx / .xls).
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [
            'file.required' => 'File Excel wajib dipilih.',
            'file.mimes'    => 'Format file harus .xlsx atau .xls.',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            $import = new PendudukImport();
            Excel::import($import, $request->file('file'));

            $imported = $import->getImportedCount();
            $skipped  = $import->getSkippedCount();
            $errors   = $import->errors();

            $message = "Berhasil mengimpor {$imported} data penduduk.";
            if ($skipped > 0) {
                $message .= " {$skipped} data dilewati (NIK sudah terdaftar).";
            }
            if ($errors->count() > 0) {
                $message .= " {$errors->count()} baris gagal karena error.";
            }

            return redirect()->route('admin.penduduk.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.penduduk.index')
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk import data penduduk.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Penduduk');

        // Header kolom
        $headers = [
            'A1' => 'nik',
            'B1' => 'no_kk',
            'C1' => 'nama',
            'D1' => 'tempat_lahir',
            'E1' => 'tanggal_lahir',
            'F1' => 'jenis_kelamin',
            'G1' => 'alamat',
            'H1' => 'rt',
            'I1' => 'rw',
            'J1' => 'desa',
            'K1' => 'kecamatan',
            'L1' => 'agama',
            'M1' => 'pekerjaan',
            'N1' => 'status_perkawinan',
            'O1' => 'kewarganegaraan',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10B981']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        $sheet->getStyle('A1:O1')->applyFromArray($headerStyle);

        // Contoh data (baris 2)
        $example = [
            'A2' => '3328010101900099',
            'B2' => '3328011234560099',
            'C2' => 'Nama Lengkap Warga',
            'D2' => 'Tegal',
            'E2' => '1990-01-01',
            'F2' => 'Laki-laki',
            'G2' => 'Jl. Contoh No. 1',
            'H2' => '001',
            'I2' => '002',
            'J2' => 'Ketileng',
            'K2' => 'Kramat',
            'L2' => 'Islam',
            'M2' => 'Wiraswasta',
            'N2' => 'Kawin',
            'O2' => 'WNI',
        ];

        foreach ($example as $cell => $value) {
            $sheet->setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        // Style contoh data
        $exampleStyle = [
            'font' => ['italic' => true, 'color' => ['rgb' => '94A3B8']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E8F0']]],
        ];
        $sheet->getStyle('A2:O2')->applyFromArray($exampleStyle);

        // Auto-size kolom
        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Format kolom NIK dan No KK sebagai teks agar angka 0 di depan tidak hilang
        $sheet->getStyle('A:A')->getNumberFormat()->setFormatCode('@');
        $sheet->getStyle('B:B')->getNumberFormat()->setFormatCode('@');

        $filename = 'template_import_penduduk.xlsx';
        $tempFile = storage_path('app/' . $filename);

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }
}

