<!-- Bungkus seluruh konten dengan x-data -->
<div x-data="{ openModal: false, selected: null }">
    <!-- Container konten konsultan -->
    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-emerald-700">Data Konsultan</h2>
            <a href="{{ route('admin.konsultan.create') }}"
                class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow transition">
                <i class="ph ph-plus-circle text-lg mr-2"></i> Tambah Konsultan
            </a>
        </div>

        <!-- Table Konsultan -->
        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-sky-500 text-white">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium">No</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Foto</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Nama</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Keahlian</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Sertifikasi</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konsultanList as $konsultan)
                <tr class="border-t border-gray-200">
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">
                        @if ($konsultan->foto_profil)
                        <img src="{{ asset('storage/' . $konsultan->foto_profil) }}" alt="Foto Profil"
                            class="w-10 h-10 rounded-full object-cover border">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($konsultan->nama_usaha) }}&background=10B981&color=fff"
                            alt="Avatar" class="w-10 h-10 rounded-full object-cover border">
                        @endif
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        {{ $konsultan->user->username ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        {{ $konsultan->keahlian }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        {{ $konsultan->sertifikasi ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        @if($konsultan->status_aktif)
                        <span class="text-green-600 font-semibold">Aktif</span>
                        @else
                        <span class="text-red-500 font-semibold">Tidak Aktif</span>
                        @endif
                    </td> 
                    <td class="px-4 py-2 text-sm text-gray-800">
                        <div class="flex items-center gap-2">
                            {{-- Detail --}}
                            <button @click="selected = {
                                    username: '{{ $konsultan->user->username }}',
                                    email: '{{ $konsultan->user->email }}',
                                    keahlian: '{{ $konsultan->keahlian }}',
                                    sertifikasi: '{{ $konsultan->sertifikasi }}',
                                    nomor_sertifikat: '{{ $konsultan->nomor_sertifikat }}',
                                    tanggal_sertifikat: '{{ $konsultan->tanggal_sertifikat }}',
                                    lembaga: '{{ $konsultan->lembaga }}',
                                    bio: @js($konsultan->bio),
                                    foto_profil: '{{
                                "https://ui-avatars.com/api/?name=" . urlencode($konsultan->user->username) . "&background=10B981&color=fff"
                                }}',
                                file_sertifikat: '{{ $konsultan->file_sertifikat ? asset("storage/" . $konsultan->file_sertifikat) : null
                                }}',
                                status_aktif: {{ $konsultan->status_aktif ? 'true' : 'false' }}
                                }; openModal = true"
                                class="flex items-center justify-center px-2 py-1 border border-emerald-600 text-emerald-600
                                hover:bg-emerald-50 rounded-lg transition duration-200"
                                title="Lihat Detail"
                                >
                                <i class="ph ph-eye"></i>
                            </button>
                    
                            {{-- Edit --}}
                            <a href="{{ route('admin.konsultan.edit', $konsultan->id) }}"
                                class="flex items-center justify-center px-2 py-1 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200"
                                title="Edit Konsultan">
                                <i class="ph ph-pencil-simple"></i>
                            </a>
                    
                            {{-- Hapus --}}
                            <form action="{{ route('admin.konsultan.destroy', $konsultan->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus konsultan ini?')">
                                @csrf
                                <button type="submit"
                                    class="flex items-center justify-center px-2 py-1 border border-red-600 text-red-600 hover:bg-red-50 rounded-lg transition duration-200"
                                    title="Hapus Konsultan">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-2 text-sm text-gray-500 text-center">
                        Belum ada data konsultan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Detail Konsultan -->
    <!-- Overlay -->
    <div x-show="openModal" x-transition.opacity.duration.300ms
        class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center">

        <!-- Modal Box -->
        <div x-show="openModal" x-transition.duration.300ms
            class="bg-white w-full max-w-2xl p-6 rounded-2xl shadow-2xl z-50 relative">

            <!-- Close Button -->
            <button @click="openModal = false"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition">
                <i class="ph ph-x text-xl"></i>
            </button>

            <!-- Header -->
            <div class="flex items-center gap-4 mb-6">
                <div>
                    <img :src="selected.foto_profil" alt="Foto Profil"
                        class="w-16 h-16 rounded-full border object-cover">
                </div>
                <div>
                    <h2 class="text-xl font-bold text-emerald-700" x-text="selected.username"></h2>
                    <p class="text-sm text-gray-500" x-text="selected.email"></p>
                </div>
            </div>

            <!-- Content -->
            <template x-if="selected">
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <span class="font-medium text-gray-600">Keahlian:</span>
                        <div x-text="selected.keahlian"></div>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Sertifikasi:</span>
                        <div x-text="selected.sertifikasi || '-'"></div>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Nomor Sertifikat:</span>
                        <div x-text="selected.nomor_sertifikat || '-'"></div>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Tanggal Sertifikat:</span>
                        <div x-text="selected.tanggal_sertifikat || '-'"></div>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Lembaga:</span>
                        <div x-text="selected.lembaga || '-'"></div>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Status:</span>
                        <div>
                            <span x-show="selected.status_aktif"
                                class="inline-block px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                Aktif
                            </span>
                            <span x-show="!selected.status_aktif"
                                class="inline-block px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                Tidak Aktif
                            </span>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <span class="font-medium text-gray-600">Bio:</span>
                        <p class="mt-1 text-gray-700" x-text="selected.bio || '-'"></p>
                    </div>
                    <template x-if="selected.file_sertifikat">
                        <div class="col-span-2">
                            <span class="font-medium text-gray-600">File Sertifikat:</span><br>
                            <a :href="selected.file_sertifikat" target="_blank"
                                class="inline-flex mt-1 items-center px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                                <i class="ph ph-file-arrow-down mr-2 text-lg"></i> Lihat Sertifikat
                            </a>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>