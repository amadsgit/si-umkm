@extends('layouts.dashboard')
@section('title', 'Beri Feedback Konsultan')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white rounded-xl shadow-md p-6">
    <h2 class="text-xl font-bold mb-4">Beri Feedback untuk {{ $permintaan->konsultan->user->username }}</h2>

    <form action="{{ route('dashboard.umkm.konsultasi.feedback.store', $permintaan->id) }}" method="POST">
        @csrf
        <label class="block mb-2 font-medium">Rating (1-5)</label>
        <input type="number" name="rating" min="1" max="5" class="w-full border rounded px-3 py-2 mb-4" required>

        <label class="block mb-2 font-medium">Komentar (Opsional)</label>
        <textarea name="komentar" rows="4" class="w-full border rounded px-3 py-2 mb-4"
            placeholder="Tambahkan komentar..."></textarea>

        <div class="flex space-x-3">
            <a href="{{ route('dashboard.umkm.konsultasi.index') }}"
            class="flex-1 text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
            Batal
            </a>
            <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Kirim Feedback
            </button>
        </div>
    </form>
</div>
@endsection