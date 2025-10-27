<?php

namespace App\Exports;

use App\Models\JadwalPembinaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PembinaanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return JadwalPembinaan::with(['jenis', 'topik', 'creator', 'pesertaPembinaan'])
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Judul',
            'Jenis',
            'Topik',
            'Tanggal',
            'Lokasi',
            'Kuota',
            'Peserta',
            'Dibuat Oleh',
        ];
    }

    public function map($item): array
    {
        return [
            $item->judul,
            $item->jenis->nama_pembinaan ?? '-',
            $item->topik->nama_topik_pembinaan ?? '-',
            $item->tanggal->format('d-m-Y'),
            $item->lokasi,
            $item->kuota,
            $item->pesertaPembinaan->count(),
            $item->creator->username ?? '-',
        ];
    }
}
