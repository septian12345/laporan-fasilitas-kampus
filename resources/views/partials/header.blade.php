{{-- Simpan sebagai: resources/views/partials/header.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Laporan Fasilitas Kampus' }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">🏫 Laporan Fasilitas Kampus</div>
        <div class="navbar-links">
            @auth
                @if(auth()->user()->role === 'mahasiswa')
                    <a href="{{ route('laporan.index') }}">Laporan Saya</a>
                    <a href="{{ route('laporan.create') }}">Buat Laporan</a>
                @else
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                @endif
                <span class="navbar-user">{{ auth()->user()->name }} <em>({{ auth()->user()->role }})</em></span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-link">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}">Daftar</a>
            @endauth
        </div>
    </nav>
    <main class="container">
        @if(session('success'))
            <p class="alert-success">{{ session('success') }}</p>
        @endif
