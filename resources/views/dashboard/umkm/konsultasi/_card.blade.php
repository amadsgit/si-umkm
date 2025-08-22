<div x-data="{ openDetail: false }"
    class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition p-5 flex flex-col justify-between">

    {{-- Judul / Topik --}}
    <div>
        <h2 class="text-lg font-semibold text-sky-700">
            {{ $permintaan->topik->nama_topik }}
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Konsultan: {{ $permintaan->konsultan->user->username ?? '-' }}
        </p>
    </div>

    {{-- Tanggal & Status --}}
    <div class="mt-4 space-y-2 text-sm">
        <div class="flex items-center gap-2 text-gray-600">
            <i class="ph ph-calendar text-emerald-600"></i>
            {{ $permintaan->created_at->format('d F Y') }}
        </div>
        <div>
            @if($permintaan->status == 'pending')
            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-medium">Menunggu Persetujuan</span>
            @elseif($permintaan->status == 'disetujui')
            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-medium">Disetujui & Dijadwalkan</span>
            @elseif($permintaan->status == 'ditolak')
            <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium">Ditolak</span>
            @elseif($permintaan->status == 'selesai')
            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-medium">Selesai</span>
            @endif
        </div>
    </div>
    {{-- Notifikasi Sedang Berlangsung --}}
    @if(
    $permintaan->status == 'disetujui'
    && $permintaan->jadwal
    && \Carbon\Carbon::now()->between(
    \Carbon\Carbon::parse($permintaan->jadwal->tanggal . ' ' . $permintaan->jadwal->waktu_mulai),
    \Carbon\Carbon::parse($permintaan->jadwal->tanggal . ' ' . $permintaan->jadwal->waktu_selesai)
    )
    )
    <div
        class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm font-semibold flex items-center gap-2">
        <i class="ph ph-video-camera"></i>
        Konsultasi sedang berlangsung sekarang.
        @if($permintaan->jadwal->metode == 'online')
        <a href="{{ $permintaan->jadwal->lokasi_link }}" target="_blank" class="ml-2 underline text-green-800">
            Bergabung
        </a>
        @endif
    </div>
    @endif

    @if($permintaan->status == 'disetujui' && $permintaan->jadwal)
    <div class="mt-3 text-sm text-gray-700">
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($permintaan->jadwal->tanggal)->translatedFormat('d F Y') }}
        </p>
        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($permintaan->jadwal->waktu_mulai)->format('H:i') }} - {{
            \Carbon\Carbon::parse($permintaan->jadwal->waktu_selesai)->format('H:i') }} WIB</p>
        <p><strong>Metode:</strong> {{ ucfirst($permintaan->jadwal->metode) }}</p>
    </div>
    @endif

    {{-- Countdown sebelum mulai --}}
    @if(
    $permintaan->status == 'disetujui' &&
    $permintaan->jadwal &&
    \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($permintaan->jadwal->tanggal . ' ' . $permintaan->jadwal->waktu_mulai))
    )
    <div x-data="{
                targetTime: new Date('{{ \Carbon\Carbon::parse($permintaan->jadwal->tanggal . ' ' . $permintaan->jadwal->waktu_mulai)->format('Y-m-d H:i:s') }}').getTime(),
                now: new Date().getTime(),
                countdown: '',
                init() {
                    this.updateCountdown();
                    setInterval(() => { this.updateCountdown(); }, 1000);
                },
                updateCountdown() {
                    this.now = new Date().getTime();
                    let distance = this.targetTime - this.now;
    
                    if (distance <= 0) {
                        this.countdown = 'Konsultasi dimulai sekarang';
                        return;
                    }
    
                    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
                    this.countdown = `${days}h ${hours}j ${minutes}m ${seconds}d`;
                }
            }" x-init="init()"
        class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg text-red-500 text-sm font-semibold flex items-center gap-2">
        <i class="ph ph-hourglass"></i>
        <span>Mulai dalam <span x-text="countdown"></span></span>
    </div>
    @endif

    {{-- Tombol Aksi --}}
    <div class="flex items-center gap-2 mt-5">
        <button @click="openDetail = true"
            class="flex items-center justify-center px-3 py-1 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-lg transition text-sm"
            title="Lihat Detail">
            <i class="ph ph-eye"></i> Detail
        </button>

        @if($permintaan->status == 'pending')
        <form action="{{ route('dashboard.umkm.konsultasi.cancel', $permintaan->id) }}" method="POST"
            onsubmit="return confirm('Yakin ingin membatalkan permintaan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="flex items-center justify-center px-3 py-1 border border-red-600 text-red-600 hover:bg-red-50 rounded-lg transition text-sm"
                title="Batalkan">
                <i class="ph ph-x"></i> Batal
            </button>
        </form>
        @endif
    </div>

    {{-- Modal Detail --}}
    <div x-show="openDetail" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" style="display: none;">
        <div @click.away="openDetail = false" class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <h3 class="text-lg font-bold text-emerald-700 mb-4">Detail Konsultasi</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p><strong>Topik:</strong> {{ $permintaan->topik->nama_topik }}</p>
                <p><strong>Konsultan:</strong> {{ $permintaan->konsultan->user->username ?? '-' }}</p>
                <p><strong>Preferensi Tanggal:</strong> {{
                    \Carbon\Carbon::parse($permintaan->preferensi_tanggal)->format('d F Y') }}</p>
                <p><strong>Deskripsi Masalah:</strong> {{ $permintaan->deskripsi_masalah ?? '-' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($permintaan->status) }}</p>
                <p><strong>Dibuat pada:</strong> {{ $permintaan->created_at->format('d F Y H:i') }}</p>
    
                @if($permintaan->status == 'disetujui' && $permintaan->jadwal)
                <hr class="my-3">
                <h4 class="text-md font-semibold text-emerald-600">Jadwal Konsultasi</h4>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($permintaan->jadwal->tanggal)->translatedFormat('d F
                    Y') }}</p>
                <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($permintaan->jadwal->waktu_mulai)->format('H:i') }} - {{
                    \Carbon\Carbon::parse($permintaan->jadwal->waktu_selesai)->format('H:i') }} WIB</p>
                <p><strong>Metode:</strong> {{ ucfirst($permintaan->jadwal->metode) }}</p>
                @if($permintaan->jadwal->metode == 'online')
                <p><strong>Link:</strong> <a href="{{ $permintaan->jadwal->lokasi_link }}" class="text-blue-600 underline"
                        target="_blank">Klik di sini</a></p>
                @else
                <p><strong>Lokasi:</strong> {{ $permintaan->jadwal->lokasi_link }}</p>
                @endif
                @endif
            </div>
            <div class="mt-4 flex justify-end">
                <button @click="openDetail = false"
                    class="mt-4 px-4 py-2 bg-white-600 border border-dark rounded-lg hover:bg-gray-200 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>