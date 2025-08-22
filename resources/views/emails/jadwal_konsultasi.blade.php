@component('mail::message')
# Jadwal Konsultasi

Yth. {{ $role === 'umkm' ? $jadwal->permintaan->umkm->user->username : $jadwal->permintaan->konsultan->user->username
}},

Dengan hormat, berikut kami sampaikan jadwal kegiatan konsultasi:

**Nama UMKM:** {{ $jadwal->permintaan->umkm->nama_usaha ?? '-' }}
**Topik Konsultasi:** {{ $jadwal->permintaan->topik->nama_topik ?? '-' }}
**Tanggal:** {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}
**Waktu:** {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{
\Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }} WIB
**Metode:** {{ ucfirst($jadwal->metode) }}

@if($jadwal->metode === 'online')
**Tautan Pertemuan:** [Klik di sini]({{ $jadwal->lokasi_link }})
@else
**Lokasi Pertemuan:** {{ $jadwal->lokasi_link }}
@endif

Mohon untuk hadir tepat waktu sesuai jadwal yang telah ditetapkan.
Apabila terdapat kendala atau perubahan, harap menghubungi pihak terkait secepatnya.

Terima kasih atas perhatian dan kerja samanya.

Hormat kami,
{{ config('app.name') }}
@endcomponent