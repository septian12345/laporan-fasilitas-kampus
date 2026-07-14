{{-- Simpan sebagai: resources/views/admin/dashboard.blade.php --}}
@include('partials.header', ['title' => 'Dashboard Admin'])

<h1>Dashboard Petugas</h1>

<div class="stats-row">
    <div class="stat-box"><strong>{{ $stats['total'] }}</strong><span>Total Laporan</span></div>
    <div class="stat-box"><strong>{{ $stats['menunggu'] }}</strong><span>Menunggu</span></div>
    <div class="stat-box"><strong>{{ $stats['diproses'] }}</strong><span>Diproses</span></div>
    <div class="stat-box"><strong>{{ $stats['selesai'] }}</strong><span>Selesai</span></div>
</div>

<div class="filter-bar">
    <a href="{{ route('admin.dashboard', ['status' => 'semua']) }}" class="{{ $filter === 'semua' ? 'active' : '' }}">Semua</a>
    <a href="{{ route('admin.dashboard', ['status' => 'menunggu']) }}" class="{{ $filter === 'menunggu' ? 'active' : '' }}">Menunggu</a>
    <a href="{{ route('admin.dashboard', ['status' => 'diproses']) }}" class="{{ $filter === 'diproses' ? 'active' : '' }}">Diproses</a>
    <a href="{{ route('admin.dashboard', ['status' => 'selesai']) }}" class="{{ $filter === 'selesai' ? 'active' : '' }}">Selesai</a>
    <a href="{{ route('admin.dashboard', ['status' => 'ditolak']) }}" class="{{ $filter === 'ditolak' ? 'active' : '' }}">Ditolak</a>
</div>

@if($laporan->isEmpty())
    <div class="card empty-state"><p>Tidak ada laporan untuk filter ini.</p></div>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Pelapor</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $l)
                <tr>
                    <td><a href="{{ route('laporan.show', $l) }}">{{ $l->judul }}</a></td>
                    <td>{{ $l->user->name }}</td>
                    <td>{{ $l->kategori->nama_kategori }}</td>
                    <td>{{ $l->lokasi }}</td>
                    <td><span class="badge badge-{{ $l->status }}">{{ $l->statusLabel() }}</span></td>
                    <td class="small muted">{{ $l->created_at->translatedFormat('d M Y') }}</td>
                    <td>
                        <form action="{{ route('admin.updateStatus', $l) }}" method="POST" class="inline-form">
                            @csrf
                            @method('PUT')
                            <select name="status_baru">
                                <option value="menunggu" @selected($l->status === 'menunggu')>Menunggu</option>
                                <option value="diproses" @selected($l->status === 'diproses')>Diproses</option>
                                <option value="selesai" @selected($l->status === 'selesai')>Selesai</option>
                                <option value="ditolak" @selected($l->status === 'ditolak')>Ditolak</option>
                            </select>
                            <input type="text" name="catatan" placeholder="Catatan (opsional)" class="catatan-input">
                            <button type="submit" class="btn-small">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@include('partials.footer')
