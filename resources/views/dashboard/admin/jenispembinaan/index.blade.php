@extends('layouts.dashboard')
@section('title', 'Data Jenis Pembinaan')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-lg space-y-6">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-3 text-emerald-700">
        Kelola Pembinaan
    </h1>

    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-6">
            <a href="{{ route('admin.jenis-pembinaan.index') }}"
                class="pb-2 border-b-2 {{ request()->routeIs('admin.jenis-pembinaan.*') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-600' }} font-medium text-sm">
                Jenis Pembinaan
            </a>
            <a href="{{ route('admin.topik-pembinaan.index') }}"
                class="pb-2 border-b-2 {{ request()->routeIs('admin.topik-pembinaan.*') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-600' }} font-medium text-sm">
                Topik Pembinaan
            </a>
        </nav>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-emerald-700">Daftar Jenis Pembinaan</h2>
            <a href="{{ route('admin.jenis-pembinaan.create') }}"
                class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow transition">
                <i class="ph ph-plus-circle text-lg mr-2"></i> Tambah Jenis
            </a>
        </div>

        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">No</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama Pembinaan</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Deskripsi</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">dibuat oleh</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisPembinaanList as $item)
                <tr class="border-t border-gray-200">
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $item->nama_pembinaan }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 300) }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        {{ $item->creator->username ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        <div class="flex items-center gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('admin.jenis-pembinaan.edit', $item->id) }}"
                                class="flex items-center justify-center px-2 py-1 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200"
                                title="Edit Topik">
                                <i class="ph ph-pencil-simple"></i>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('admin.jenis-pembinaan.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus jenis pembinaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex items-center justify-center px-2 py-1 border border-red-600 text-red-600 hover:bg-red-50 rounded-lg transition duration-200"
                                    title="Hapus Jenis Pembinaan">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-sm text-gray-500 text-center">
                        Belum ada data jenis pembinaan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 mb-4">
            {{ $jenisPembinaanList->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection