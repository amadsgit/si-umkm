<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermintaanKonsultasi;
use Carbon\Carbon;

class PermintaanKonsultasiSeeder extends Seeder
{
    public function run()
    {
        PermintaanKonsultasi::insert([
            [
                'umkm_id' => 18,
                'topik_id' => 4,
                'konsultan_id' => null, // belum dipilih admin
                'preferensi_tanggal' => Carbon::now()->addDays(3),
                'deskripsi_masalah' => 'Ingin mendapatkan strategi pemasaran yang efektif untuk meningkatkan penjualan produk.',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'umkm_id' => 18,
                'topik_id' => 5,
                'konsultan_id' => 19, // sudah dipilih admin
                'preferensi_tanggal' => Carbon::now()->addDays(5),
                'deskripsi_masalah' => 'Perlu bantuan membuat pembukuan keuangan usaha yang lebih rapi.',
                'status' => 'disetujui',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'umkm_id' => 18,
                'topik_id' => 6,
                'konsultan_id' => 19,
                'preferensi_tanggal' => Carbon::now()->subDays(2),
                'deskripsi_masalah' => 'Telah melakukan konsultasi terkait desain kemasan dan ingin mendapatkan review hasil.',
                'status' => 'selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}