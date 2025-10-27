<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\JadwalKonsultasi;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KonsultasiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return JadwalKonsultasi::with(['hasilKonsultasi'])
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Waktu',
            'Metode',
            'Lokasi / Link',
            'Status',
            'Hasil',
        ];
    }

    public function map($item): array
    {
        return [
            Carbon::parse($item->tanggal)->format('d-m-Y'),
            $item->waktu_mulai . ' - ' . $item->waktu_selesai,
            ucfirst($item->metode),
            $item->lokasi_link ?? '-',
            ucfirst($item->status),
            $item->hasilKonsultasi->ringkasan ?? '-',
        ];
    }
}
