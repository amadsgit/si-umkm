<div class="bg-white p-6 rounded-xl shadow">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-emerald-700">Data Kepala UPTD</h2>
        <a href="{{ route('admin.kepalauptd.create') }}"
            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow transition">
            <i class="ph ph-plus-circle text-lg mr-2"></i> Tambah Kepala UPTD
        </a>
    </div>

    <table class="min-w-full table-auto border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">No</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Foto</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">NIP</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Jabatan</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kepalaUptdList as $kepala)
            <tr class="border-t border-gray-200">
                <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">
                    @if ($kepala->foto_profil)
                    <img src="{{ asset('storage/' . $kepala->foto_profil) }}" alt="Foto Profil"
                        class="w-10 h-10 rounded-full object-cover border">
                    @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($kepala->jabatan) }}&background=10B981&color=fff"
                        alt="Avatar" class="w-10 h-10 rounded-full object-cover border">
                    @endif
                </td>
                <td class="px-4 py-2 text-sm text-gray-800">{{ $kepala->user->username }}</td>
                <td class="px-4 py-2 text-sm text-gray-800">{{ $kepala->nip }}</td>
                <td class="px-4 py-2 text-sm text-gray-800">{{ $kepala->jabatan }}</td>
                <td class="px-4 py-2 text-sm text-gray-800">
                    @if($kepala->status_aktif)
                    <span class="text-green-600 font-semibold">Aktif</span>
                    @else
                    <span class="text-red-500 font-semibold">Tidak Aktif</span>
                    @endif
                </td>
                <td class="px-4 py-2 text-sm text-gray-800">
                    <div class="flex items-center gap-2">
                    {{-- Edit --}}
                        <a href="{{ route('admin.kepalauptd.edit', $kepala->id) }}"
                            class="flex items-center justify-center px-2 py-1 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200"
                            title="Edit kepala UPTD">
                            <i class="ph ph-pencil-simple"></i>
                        </a>
                        
                        {{-- Hapus --}}
                        <form action="{{ route('admin.kepalauptd.destroy', $kepala->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus Kepala UPTD ini?')">
                            @csrf
                            <button type="submit"
                                class="flex items-center justify-center px-2 py-1 border border-red-600 text-red-600 hover:bg-red-50 rounded-lg transition duration-200"
                                title="Hapus Kepala UPTD">
                                <i class="ph ph-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-2 text-sm text-gray-500 text-center">
                    Belum ada data Kepala UPTD.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>