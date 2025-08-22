<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-semibold mb-4 text-emerald-700">Data UMKM Terdaftar</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Foto</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama Pemilik</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama Usaha</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Bidang Usaha</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Alamat</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tahun Berdiri</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Kategori</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($umkmList as $umkm)
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">
                        @if ($umkm->foto_profil)
                        <img src="{{ asset('storage/' . $umkm->foto_profil) }}" alt="Foto Profil"
                            class="w-10 h-10 rounded-full object-cover border">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($umkm->nama_usaha) }}&background=10B981&color=fff"
                            alt="Avatar" class="w-10 h-10 rounded-full object-cover border">
                        @endif
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $umkm->user->username }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $umkm->nama_usaha }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $umkm->bidang_usaha }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $umkm->alamat_usaha }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $umkm->tahun_berdiri }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $umkm->kategori_usaha }}</td>
                    <td class="px-4 py-2 text-sm">
                        {{-- Hapus --}}
                        <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus UMKM ini?')">
                            @csrf
                            <button type="submit"
                                class="flex items-center justify-center px-2 py-1 border border-red-600 text-red-600 hover:bg-red-50 rounded-lg transition duration-200"
                                title="Hapus UMKM">
                                <i class="ph ph-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 px-4 py-4">
                        Belum ada data UMKM.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>