{{-- Simpan sebagai: resources/views/laporan/show.blade.php --}}
@include('partials.header', ['title' => $laporan->judul])

<div class="card">
    <div class="card-top">
        <span class="badge badge-{{ $laporan->status }}">{{ $laporan->statusLabel() }}</span>
        <span class="muted small">{{ $laporan->created_at->translatedFormat('d M Y H:i') }}</span>
    </div>

    <h1>{{ $laporan->judul }}</h1>
    <p class="muted">{{ $laporan->kategori->nama_kategori }} · {{ $laporan->lokasi }}</p>
    <p>{{ $laporan->deskripsi }}</p>

    @if($laporan->foto)
        <img src="{{ asset('storage/' . $laporan->foto) }}" class="report-photo">
    @endif
</div>

<div class="card">
    <h2>Riwayat Progres</h2>
    @if($laporan->progres->isEmpty())
        <p class="muted">Laporan masih menunggu ditinjau petugas.</p>
    @else
        <ul class="timeline">
            @foreach($laporan->progres as $p)
                <li>
                    <span class="badge badge-{{ $p->status_baru }}">{{ $p->statusLabel() }}</span>
                    <span class="muted small">{{ $p->created_at->translatedFormat('d M Y H:i') }}</span>
                    @if($p->catatan)
                        <p>{{ $p->catatan }}</p>
                    @endif
                    <p class="muted small">oleh {{ $p->petugas->name }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>

<a href="{{ route('laporan.index') }}" class="btn-link">&larr; Kembali ke Daftar Laporan</a>

@include('partials.footer')
