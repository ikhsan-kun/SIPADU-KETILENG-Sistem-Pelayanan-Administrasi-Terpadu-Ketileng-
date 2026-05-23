<?php

namespace App\Imports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\Importable;

class PendudukImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;

    private int $imported = 0;
    private int $skipped = 0;

    /**
     * Mapping setiap baris Excel ke model Penduduk.
     * Kolom heading di Excel harus sesuai: nik, no_kk, nama, dst.
     */
    public function model(array $row)
    {
        // Skip jika NIK sudah ada (update bisa ditambahkan nanti)
        if (Penduduk::where('nik', $row['nik'])->exists()) {
            $this->skipped++;
            return null;
        }

        $this->imported++;

        return new Penduduk([
            'nik'               => $row['nik'],
            'no_kk'             => $row['no_kk'],
            'nama'              => $row['nama'],
            'tempat_lahir'      => $row['tempat_lahir'],
            'tanggal_lahir'     => $this->parseDate($row['tanggal_lahir']),
            'jenis_kelamin'     => $row['jenis_kelamin'],
            'alamat'            => $row['alamat'],
            'rt'                => $row['rt'] ?? null,
            'rw'                => $row['rw'] ?? null,
            'desa'              => $row['desa'] ?? 'Ketileng',
            'kecamatan'         => $row['kecamatan'] ?? 'Kramat',
            'agama'             => $row['agama'] ?? 'Islam',
            'pekerjaan'         => $row['pekerjaan'] ?? null,
            'status_perkawinan' => $row['status_perkawinan'] ?? 'Belum Kawin',
            'kewarganegaraan'   => $row['kewarganegaraan'] ?? 'WNI',
        ]);
    }

    /**
     * Aturan validasi untuk setiap baris.
     */
    public function rules(): array
    {
        return [
            'nik'           => ['required', 'string'],
            'no_kk'         => ['required', 'string'],
            'nama'          => ['required', 'string'],
            'tempat_lahir'  => ['required', 'string'],
            'tanggal_lahir' => ['required'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan,L,P'],
            'alamat'        => ['required', 'string'],
        ];
    }

    /**
     * Parse tanggal dari berbagai format (Excel serial number, string, dll).
     */
    private function parseDate($value): string
    {
        if (empty($value)) {
            return now()->format('Y-m-d');
        }

        // Jika berupa angka (Excel serial date number)
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int) $value)->format('Y-m-d');
        }

        // Coba parse berbagai format tanggal
        $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'd/m/y', 'm/d/Y'];
        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $value);
            if ($date !== false) {
                return $date->format('Y-m-d');
            }
        }

        return $value;
    }

    public function getImportedCount(): int
    {
        return $this->imported;
    }

    public function getSkippedCount(): int
    {
        return $this->skipped;
    }
}
