{{-- Simpan sebagai: resources/views/laporan/index.blade.php --}}
@include('partials.header', ['title' => 'Laporan Saya'])

<div class="page-header">
    <h1>Laporan Saya</h1>
    <a href="{{ route('laporan.create') }}" class="btn-primary">+ Buat Laporan Baru</a>
</div>

@if($laporan->isEmpty())
    <div class="card empty-state">
        <p>Kamu belum membuat laporan apa pun.</p>
        <a href="{{ route('laporan.create') }}" class="btn-primary">Buat Laporan Pertama</a>
    </div>
@else
    <div class="grid">
        @foreach($laporan as $l)
            <a href="{{ route('laporan.show', $l) }}" class="card card-link">
                <div class="card-top">
                    <span class="badge badge-{{ $l->status }}">{{ $l->statusLabel() }}</span>
                    <span class="muted small">{{ $l->created_at->translatedFormat('d M Y') }}</span>
                </div>
                <h3>{{ $l->judul }}</h3>
                <p class="muted">{{ $l->kategori->nama_kategori }} · {{ $l->lokasi }}</p>
            </a>
        @endforeach
    </div>
@endif

@include('partials.footer')
