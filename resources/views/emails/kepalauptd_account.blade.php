<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Akun Kepala UPTD</title>
</head>

<body>
    <h2>Selamat datang, {{ $username }}!</h2>
    <p>Anda telah didaftarkan sebagai kepala UPTD di sistem kami.</p>
    <p>Silakan login menggunakan detail berikut:</p>

    <ul>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

    <p>Silakan login ke sistem melalui halaman login. Pastikan untuk mengganti password Anda setelah login pertama.</p>

    <p>Terima kasih.</p>
    <p>Admin. SIMPKU (Sistem Informasi Manajemen Pembinaan & Konsultasi UMKM)</p>
</body>

</html>