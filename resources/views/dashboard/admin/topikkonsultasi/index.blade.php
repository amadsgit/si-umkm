@extends('layouts.dashboard')
@section('title', 'Data Topik Konsultasi')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-lg space-y-6">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-3 text-emerald-700">
        Data Topik Konsultasi
    </h1>

    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-emerald-700">Daftar Topik Konsultasi</h2>
            <a href="{{ route('admin.topik-konsultasi.create') }}"
                class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow transition">
                <i class="ph ph-plus-circle text-lg mr-2"></i> Tambah Topik
            </a>
        </div>

        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">No</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama Topik</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Deskripsi</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topikKonsultasiList as $topik)
                <tr class="border-t border-gray-200">
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $topik->nama_topik }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        {{ \Illuminate\Support\Str::limit($topik->deskripsi, 300) }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        @if($topik->is_aktif)
                        <span class="text-green-600 font-semibold">Aktif</span>
                        @else
                        <span class="text-red-500 font-semibold">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        <div class="flex items-center gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('admin.topik-konsultasi.edit', $topik->id) }}"
                                class="flex items-center justify-center px-2 py-1 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200"
                                title="Edit Topik">
                                <i class="ph ph-pencil-simple"></i>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('admin.topik-konsultasi.destroy', $topik->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus topik ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex items-center justify-center px-2 py-1 border border-red-600 text-red-600 hover:bg-red-50 rounded-lg transition duration-200"
                                    title="Hapus Topik">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-sm text-gray-500 text-center">
                        Belum ada data topik konsultasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection