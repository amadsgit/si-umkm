@extends('landing.layout')
@section('title', 'Login | SIMPKU Kab. Subang')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-12">
    <div
        class="flex flex-col md:flex-row max-w-4xl w-full bg-white shadow-xl rounded-xl overflow-hidden animate-fade-in">

        <!-- Ilustrasi / Branding -->
        <div class="hidden md:flex w-1/2 bg-emerald-100 items-center justify-center p-6">
            <img src="/images/logosimpku.png" alt="UMKM Illustration" class="w-4/5 h-auto rounded-xl" />
        </div>

        <!-- Form Login -->
        <div class="w-full md:w-1/2 p-10 space-y-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">
                    Login <span class="text-emerald-500">SIMPKU</span>
                </h2>
            </div>

            <form class="space-y-5" action="{{ route('login') }}" method="POST">
                @csrf

                @if ($errors->any())
                <div class="text-red-500 text-sm">
                    {{ $errors->first() }}
                </div>
                @endif
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password"
                        class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition" />
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-emerald-600 mr-2" />
                        Ingat saya
                    </label>
                    <a href="#" class="text-sm text-emerald-600 hover:underline">Lupa
                        password?</a>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full py-2 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-md shadow-sm transition">
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register.umkm.form') }}"
                    class="text-emerald-600 hover:underline">Daftar di sini</a>
            </p>
            <p class="text-center text-sm text-gray-500">
                <a href="/" class="text-emerald-600 hover:underline">Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</div>
@endsection