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
    <section>
        <h2 class="text-xl font-bold text-gray-600 mb-4">Konsultasi Disetujui</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 border">No</th>
                        <th class="px-3 py-2 border">UMKM</th>
                        <th class="px-3 py-2 border">Topik</th>
                        <th class="px-3 py-2 border">Status</th>
                        <th class="px-3 py-2 border">Tgl Preferensi</th>
                        <th class="px-3 py-2 border">Tgl Pengajuan</th>
                        <th class="px-3 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($disetujui as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-3 py-2">{{ $item->umkm->nama_usaha }}</td>
                        <td class="border px-3 py-2">{{ $item->topik->nama_topik }}</td>
                        <td class="border px-3 py-2">{{ $item->status }}</td>
                        <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($item->tanggal_preferensi)->format('d M Y') }}</td>
                        <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                        <td class="border px-3 py-2">
                            <button @click.prevent="openJadwal({{ $item->id }})"
                                class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">
                                Penjadwalan
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-3">Tidak ada permintaan disetujui.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- === 3. Permintaan dijadwalkan=== --}}
    <section>
        <h2 class="text-xl font-bold text-emerald-500 mb-4">Konsultasi Dijadwalkan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm">
                <thead class="bg-emerald-500 text-white">
                    <tr>
                        <th class="px-3 py-2 border">No</th>
                        <th class="px-3 py-2 border">UMKM</th>
                        <th class="px-3 py-2 border">Topik</th>
                        <th class="px-3 py-2 border">Konsultan</th>
                        <th class="px-3 py-2 border">Jadwal Kegiatan</th>
                        <th class="px-3 py-2 border">Link/Lokasi</th>
                        <th class="px-3 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dijadwalkan as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-3 py-2">{{ $item->umkm->nama_usaha }}</td>
                        <td class="border px-3 py-2">{{ $item->topik->nama_topik }}</td>
                        <td class="border px-3 py-2">{{ $item->konsultan->user->username ?? '-' }}</td>
                        <td class="border font-bold px-3 py-2">
                            @if($item->jadwal)
                            {{-- Format tanggal --}}
                            {{ \Carbon\Carbon::parse($item->jadwal->tanggal)->format('d M Y') }}
                        
                            {{-- Format jam tanpa detik --}}
                            {{ \Carbon\Carbon::parse($item->jadwal->waktu_mulai)->format('H.i') }} -
                            {{ \Carbon\Carbon::parse($item->jadwal->waktu_selesai)->format('H.i') }}
                        
                            {{-- Countdown --}}
                            @php
                            $waktuMulai = \Carbon\Carbon::parse($item->jadwal->tanggal . ' ' . $item->jadwal->waktu_mulai);
                            $now = now();
                            @endphp
                        
                            @if($now->lessThan($waktuMulai))
                            <span class="text-sm text-emerald-600">
                                ({{ $now->diffForHumans($waktuMulai, [
                                'parts' => 2,
                                'join' => true
                                ]) }})
                            </span>
                            @else
                            <span class="text-sm text-red-500">(Sedang berlangsung / Selesai)</span>
                            @endif
                            @else
                            <span class="text-gray-500">Belum dijadwalkan</span>
                            @endif
                        </td>
                        <td class="border px-3 py-2">
                            @if($item->jadwal)
                            {{ ucfirst($item->jadwal->metode) }}<br>
                        
                            @if(Str::startsWith($item->jadwal->lokasi_link, ['http://', 'https://']))
                            {{-- Link Online --}}
                            <a href="{{ $item->jadwal->lokasi_link }}" target="_blank" class="text-blue-600 underline">
                                {{ $item->jadwal->lokasi_link }}
                            </a>
                            @else
                            {{-- Alamat Offline --}}
                            <span class="text-gray-800">{{ $item->jadwal->lokasi_link }}</span>
                            @endif
                        
                            @else
                            <span class="text-gray-500">Belum ada lokasi/link</span>
                            @endif
                        </td>
                        <td class="border px-3 py-2">
                            <button @click.prevent="editJadwal({{ $item->jadwal->id }})"
                                class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-3">Tidak ada permintaan dijadwalkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- === Modal Pending (Alpine-controlled via jadwalPage()) === --}}
    <div x-show="showPending" x-transition.opacity.200
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" style="display: none;">
        <div @click.away="closePending()" class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Persetujuan Permintaan Konsultasi</h3>

            {{-- dynamic action menggunakan selectedId --}} 
            <form :action="`/dashboard/admin/update-permintaan/${selectedId}/status`" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="permintaan_id" :value="selectedId">

                <p class="mb-4 text-gray-600">Pilih status persetujuan untuk permintaan konsultasi ini:</p>

                <select name="status" class="w-full border rounded p-2 mb-4" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="closePending()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">Simpan</button>
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