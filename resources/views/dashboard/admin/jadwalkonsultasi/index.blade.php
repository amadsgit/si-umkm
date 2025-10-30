@extends('layouts.dashboard')
@section('title', 'Jadwal Konsultasi')

@section('content')
<div x-data="jadwalPage()" class="space-y-10">

    {{-- === 1. Permintaan Pending === --}}
    <section>
        <h2 class="text-xl font-bold text-amber-600 mb-4">Permintaan Pending</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($pending as $item)
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="font-semibold text-gray-800">{{ $item->umkm->nama_usaha }}</h3>
                <p class="text-sm text-gray-500">{{ $item->topik->nama_topik }}</p>
                {{-- panggil method Alpine openPending --}}
                <button @click.prevent="openPending({{ $item->id }})"
                    class="mt-3 w-full bg-emerald-500 text-white px-3 py-1 rounded hover:bg-emerald-600 text-sm">
                    Pratinjau
                </button>
            </div>
            @empty
            <p class="text-gray-500">Tidak ada permintaan pending.</p>
            @endforelse
        </div>
    </section>


    {{-- === 2. Permintaan Disetujui (Belum Selesai) === --}}
    <section class="mb-10">
        <div class="flex items-center gap-2 mb-5">
            <div class="bg-blue-100 p-2 rounded-full">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m2 4v1a2 2 0 11-4 0v-1m6-2a9 9 0 11-6.708-8.708A9 9 0 0118 14z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-blue-700 tracking-wide">Konsultasi Disetujui</h2>
        </div>
    
        <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-gray-100">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">UMKM</th>
                        <th class="px-4 py-3 text-left">Topik</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Tgl Preferensi</th>
                        <th class="px-4 py-3 text-left">Tgl Pengajuan</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($disetujui as $item)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-2 font-medium text-gray-600">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $item->umkm->nama_usaha }}</td>
                        <td class="px-4 py-2">{{ $item->topik->nama_topik }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_preferensi)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                        <td class="px-4 py-2 text-center">
                            <button @click.prevent="openJadwal({{ $item->id }})"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-full text-xs transition">
                                Penjadwalan
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4 italic">
                            Tidak ada permintaan disetujui.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $disetujui->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </section>
    
    
    {{-- === 3. Permintaan Dijadwalkan === --}}
    <section>
        <div class="flex items-center gap-2 mb-5">
            <div class="bg-emerald-100 p-2 rounded-full">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2l4 -4m1-5a9 9 0 11-6.708 8.708A9 9 0 0118 14z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-emerald-600 tracking-wide">Konsultasi Dijadwalkan</h2>
        </div>
    
        <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-gray-100">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">UMKM</th>
                        <th class="px-4 py-3 text-left">Topik</th>
                        <th class="px-4 py-3 text-left">Konsultan</th>
                        <th class="px-4 py-3 text-left">Jadwal Kegiatan</th>
                        <th class="px-4 py-3 text-left">Link / Lokasi</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($dijadwalkan as $item)
                    <tr class="hover:bg-emerald-50 transition">
                        <td class="px-4 py-2 font-medium text-gray-600">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $item->umkm->nama_usaha }}</td>
                        <td class="px-4 py-2">{{ $item->topik->nama_topik }}</td>
                        <td class="px-4 py-2">{{ $item->konsultan->user->username ?? '-' }}</td>
                        <td class="px-4 py-2 font-semibold text-gray-800">
                            @if($item->jadwal)
                            {{ \Carbon\Carbon::parse($item->jadwal->tanggal)->format('d M Y') }}
                            {{ \Carbon\Carbon::parse($item->jadwal->waktu_mulai)->format('H.i') }} -
                            {{ \Carbon\Carbon::parse($item->jadwal->waktu_selesai)->format('H.i') }}
    
                            @php
                            $waktuMulai = \Carbon\Carbon::parse($item->jadwal->tanggal . ' ' . $item->jadwal->waktu_mulai);
                            $now = now();
                            @endphp
    
                            @if($now->lessThan($waktuMulai))
                            <span class="text-sm text-emerald-600 block">
                                ({{ $now->diffForHumans($waktuMulai, ['parts' => 2, 'join' => true]) }})
                            </span>
                            @else
                            <span class="text-sm text-red-500 block">(Sedang berlangsung / Selesai)</span>
                            @endif
                            @else
                            <span class="text-gray-400 italic">Belum dijadwalkan</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($item->jadwal)
                            {{ ucfirst($item->jadwal->metode) }}<br>
                            @if(Str::startsWith($item->jadwal->lokasi_link, ['http://', 'https://']))
                            <a href="{{ $item->jadwal->lokasi_link }}" target="_blank"
                                class="text-blue-600 hover:underline text-sm">
                                {{ $item->jadwal->lokasi_link }}
                            </a>
                            @else
                            <span class="text-gray-800 text-sm">{{ $item->jadwal->lokasi_link }}</span>
                            @endif
                            @else
                            <span class="text-gray-400 italic">Belum ada lokasi/link</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button @click.prevent="editJadwal({{ $item->jadwal->id }})"
                                class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-full text-xs transition">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4 italic">
                            Tidak ada permintaan dijadwalkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $dijadwalkan->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </section>

    {{-- === 4. Permintaan Konsultasi Ditolak === --}}
    <section class="mt-12">
        <div class="flex items-center gap-2 mb-5">
            <div class="bg-rose-100 p-2 rounded-full">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856A2.062 2.062 0 0021 16.938V7.062A2.062 2.062 0 0018.938 5H5.062A2.062 2.062 0 003 7.062v9.876A2.062 2.062 0 005.062 19z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-rose-600 tracking-wide">Permintaan Konsultasi Ditolak</h2>
        </div>
    
        <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-gray-100">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gradient-to-r from-rose-500 to-rose-600 text-white text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Topik</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Alasan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($ditolakList as $item)
                    <tr class="hover:bg-rose-50 transition">
                        <td class="px-4 py-2 font-medium text-gray-600">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $item->topik->nama_topik }}</td>
                        <td class="px-4 py-2">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold">
                                Ditolak
                            </span>
                        </td>
                        <td class="px-4 py-2 text-gray-700">
                            @if($item->alasan_ditolak)
                            <span class="block">{{ $item->alasan_ditolak }}</span>
                            @else
                            <span class="text-gray-400 italic">Tidak ada keterangan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4 italic">
                            Belum ada permintaan yang ditolak.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $ditolakList->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </section>





    {{-- === Modal Pending (Alpine-controlled via jadwalPage()) === --}}
    <div x-show="showPending" x-transition.opacity.200
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" style="display: none;">
        <div @click.away="closePending()" class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Persetujuan Permintaan Konsultasi</h3>

            {{-- Dynamic form --}}
            <form x-data="{ status: '' }" :action="`/dashboard/admin/update-permintaan/${selectedId}/status`" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="permintaan_id" :value="selectedId">
            
                <p class="mb-4 text-gray-600">Pilih status persetujuan untuk permintaan konsultasi ini:</p>
            
                {{-- Select status --}}
                <select name="status" x-model="status" class="w-full border rounded p-2 mb-4" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            
                {{-- Input alasan muncul hanya jika ditolak --}}
                <div x-show="status === 'ditolak'" x-transition.opacity.200>
                    <label class="block mb-2 text-gray-700 font-medium">Alasan Penolakan</label>
                    <textarea name="alasan" rows="3" class="w-full border rounded p-2 mb-4"
                        placeholder="Tuliskan alasan penolakan di sini..."></textarea>
                </div>
            
                <div class="flex justify-end gap-2">
                    <button type="button" @click="closePending()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- === Modal Jadwal (Alpine-controlled) === --}}
    <div x-show="showJadwal" x-transition.opacity.200
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" style="display: none;">
        <div @click.away="closeJadwal()" class="bg-white w-full max-w-3xl rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Penjadwalan Konsultasi</h3>
    
            <form :action="`/dashboard/admin/permintaan-konsultasi/${selectedId}/penjadwalan`" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="permintaan_id" :value="selectedId">
    
                {{-- Baris Tanggal & Waktu --}}
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block mb-2">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border rounded p-2" required>
                    </div>
                    <div>
                        <label class="block mb-2">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" class="w-full border rounded p-2" required>
                    </div>
                    <div>
                        <label class="block mb-2">Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" class="w-full border rounded p-2" required>
                    </div>
                </div>
    
                {{-- Baris Konsultan & Metode --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-2">Pilih Konsultan</label>
                        <select name="konsultan_id" class="w-full border rounded p-2" required>
                            <option value="">-- Pilih Konsultan --</option>
                            @foreach($konsultanList as $konsultan)
                            <option value="{{ $konsultan->id }}">{{ $konsultan->user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2">Metode</label>
                        <select name="metode" class="w-full border rounded p-2" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                </div>
    
                {{-- Lokasi / Link --}}
                <label class="block mb-2">Lokasi / Link</label>
                <textarea name="lokasi_link" class="w-full border rounded p-2 mb-4" required></textarea>
    
                {{-- Status Jadwal --}}
                <label class="block mb-2">Status Jadwal</label>
                <select name="status" class="w-full border rounded p-2 mb-4" required>
                    <option value="dijadwalkan">Dijadwalkan</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
    
                {{-- Tombol --}}
                <div class="flex justify-end gap-2">
                    <button type="button" @click="closeJadwal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Jadwal --}}
    <div x-show="showEditJadwal" x-transition.opacity.200
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" style="display: none;">
        <div @click.away="closeEditJadwal()" class="bg-white w-full max-w-3xl rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Edit Jadwal Konsultasi</h3>
    
            <form :action="`/dashboard/admin/jadwal/${selectedId}`" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="permintaan_id" :value="selectedId">
    
                {{-- Baris Tanggal & Waktu --}}
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block mb-2">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border rounded p-2" x-model="editForm.tanggal"
                            required>
                    </div>
                    <div>
                        <label class="block mb-2">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" class="w-full border rounded p-2"
                            x-model="editForm.waktu_mulai" required>
                    </div>
                    <div>
                        <label class="block mb-2">Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" class="w-full border rounded p-2"
                            x-model="editForm.waktu_selesai" required>
                    </div>
                </div>
    
                {{-- Baris Konsultan & Metode --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-2">Pilih Konsultan</label>
                        <select name="konsultan_id" class="w-full border rounded p-2" x-model="editForm.konsultan_id"
                            required>
                            <option value="">-- Pilih Konsultan --</option>
                            <template x-for="k in konsultanList" :key="k.id">
                                <option :value="k.id" x-text="k.user.username"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2">Metode</label>
                        <select name="metode" class="w-full border rounded p-2" x-model="editForm.metode" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                </div>
    
                {{-- Lokasi / Link --}}
                <label class="block mb-2">Lokasi / Link</label>
                <textarea name="lokasi_link" class="w-full border rounded p-2 mb-4" x-model="editForm.lokasi_link"
                    required></textarea>
    
                {{-- Status Jadwal --}}
                <label class="block mb-2">Status Jadwal</label>
                <select name="status" class="w-full border rounded p-2 mb-4" x-model="editForm.status" required>
                    <option value="dijadwalkan">Dijadwalkan</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
    
                {{-- Tombol --}}
                <div class="flex justify-end gap-2">
                    <button type="button" @click="closeEditJadwal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div> {{-- akhir x-data wrapper --}}

{{-- Alpine component script --}}
<script>
    // Pastikan Alpine sudah ter-include di layout (defer) sebelum script ini.
    function jadwalPage() {
        return {
            showPending: false,
            showJadwal: false,
            showEditJadwal: false,
            selectedId: null,

            konsultanList: @json($konsultanList),

            editForm: {
                tanggal: '',
                waktu_mulai: '',
                waktu_selesai: '',
                konsultan_id: '',
                metode: '',
                lokasi_link: '',
                status: '',
            },

            openPending(id) {
                this.selectedId = id;
                this.showPending = true;
            },
            closePending() {
                this.selectedId = null;
                this.showPending = false;
            },

            openJadwal(id) {
                this.selectedId = id;
                this.showJadwal = true;
            },
            closeJadwal() {
                this.selectedId = null;
                this.showJadwal = false;
            },

            editJadwal(id) {
                fetch(`/dashboard/admin/jadwal/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    console.log('Konsultan List:', data.konsultanList);
                    this.selectedId = id;
                    const j = data.jadwal;
                    this.editForm.tanggal = j.tanggal;
                    this.editForm.waktu_mulai = j.waktu_mulai.substring(0,5);
                    this.editForm.waktu_selesai = j.waktu_selesai.substring(0,5);
                    this.editForm.konsultan_id = j.permintaan.konsultan_id ?? '';
                    this.editForm.metode = j.metode;
                    this.editForm.lokasi_link = j.lokasi_link;
                    this.editForm.status = j.status;
                    
                    // Update konsultanList jika ingin, atau biarkan dari awal
                    this.konsultanList = data.konsultanList;
                    
                    this.showEditJadwal = true;
                });
            },

            closeEditJadwal() {
                this.selectedId = null;
                this.showEditJadwal = false;
                this.editForm = {
                tanggal: '',
                waktu_mulai: '',
                waktu_selesai: '',
                konsultan_id: '',
                metode: '',
                lokasi_link: '',
                status: '',
                };
            }
        }
    }
</script>
@endsection