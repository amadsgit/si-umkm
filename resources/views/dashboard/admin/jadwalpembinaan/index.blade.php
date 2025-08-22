@extends('layouts.dashboard')
@section('title', 'Data Jadwal Pembinaan')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-lg space-y-6">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-3 text-sky-700">
        Jadwal Pembinaan
    </h1>

    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-emerald-700">Daftar Jadwal Pembinaan</h2>
            <a href="{{ route('admin.jadwal-pembinaan.create') }}"
                class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow transition">
                <i class="ph ph-plus-circle text-lg mr-2"></i> Tambah Jadwal
            </a>
        </div>

        {{-- Wrapper supaya tabel bisa discroll di layar kecil --}}
        <div class="overflow-x-auto overflow-y-hidden">
            <table class="min-w-full table-auto border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">No</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Thumbnail</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Judul</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Jenis</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Topik</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tanggal</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Waktu</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Lokasi</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Metode</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Kuota</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Peserta</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalPembinaanList as $item)
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $jadwalPembinaanList->firstItem() + $loop->index }}</td>

                        {{-- Thumbnail --}}
                        <td class="px-4 py-2">
                            @if($item->thumbnail)
                            <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="Thumbnail"
                                class="w-16 h-16 object-cover rounded-lg">
                            @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>

                        {{-- Judul --}}
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $item->judul }}</td>

                        {{-- Jenis --}}
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $item->jenis->nama_pembinaan ?? '-' }}</td>

                        {{-- Topik --}}
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $item->topik->nama_topik_pembinaan ?? '-' }}</td>

                        {{-- Tanggal --}}
                        <td class="px-4 py-2 text-sm text-gray-800">{{
                            \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>

                        {{-- Waktu --}}
                        <td class="px-4 py-2 text-sm text-gray-800">
                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                        </td>

                        {{-- Lokasi --}}
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $item->lokasi }}</td>

                        {{-- Metode --}}
                        <td class="px-4 py-2 text-sm text-gray-800 capitalize">{{ $item->metode }}</td>

                        {{-- Kuota --}}
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $item->kuota }}</td>

                        {{-- Peserta --}}
                        <td class="px-4 py-2 text-sm text-gray-800">
                            <div class="flex items-center gap-2">
                                {{-- Badge jumlah peserta --}}
                                <span class="px-2 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-full">
                                    {{ $item->peserta_pembinaan_count }}
                                </span>
                        
                                {{-- Tombol lihat peserta --}}
                                <a href="{{ route('admin.jadwal-pembinaan.peserta', $item->id) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow transition"
                                    title="Lihat Peserta">
                                    <i class="ph ph-eye text-lg"></i>
                                </a>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-2 text-sm text-gray-800">
                            <div class="flex items-center gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('admin.jadwal-pembinaan.edit', $item->id) }}"
                                    class="flex items-center justify-center px-2 py-1 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200"
                                    title="Edit Jadwal">
                                    <i class="ph ph-pencil-simple"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.jadwal-pembinaan.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus jadwal pembinaan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center px-2 py-1 border border-red-600 text-red-600 hover:bg-red-50 rounded-lg transition duration-200"
                                        title="Hapus Jadwal">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-4 py-4 text-sm text-gray-500 text-center">
                            Belum ada data jadwal pembinaan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 mb-4">
                {{ $jadwalPembinaanList->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection