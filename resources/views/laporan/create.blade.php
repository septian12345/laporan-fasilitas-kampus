{{-- Simpan sebagai: resources/views/laporan/create.blade.php --}}
@include('partials.header', ['title' => 'Buat Laporan'])

<div class="card card-narrow">
    <h1>Buat Laporan Fasilitas</h1>

    @if($errors->any())
        <p class="alert-error">{{ $errors->first() }}</p>
    @endif

    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="form">
        @csrf

        <label>Kategori Fasilitas</label>
        <select name="kategori_fasilitas_id" required>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}" @selected(old('kategori_fasilitas_id') == $k->id)>{{ $k->nama_kategori }}</option>
            @endforeach
        </select>

        <label>Judul Laporan</label>
        <input type="text" name="judul" placeholder="Contoh: AC Ruang B2 Mati" value="{{ old('judul') }}" required>

        <label>Lokasi</label>
        <input type="text" name="lokasi" placeholder="Contoh: Gedung B, Lantai 2, Ruang B2.1" value="{{ old('lokasi') }}" required>

        <label>Deskripsi Kerusakan</label>
        <textarea name="deskripsi" rows="4" placeholder="Jelaskan kerusakan yang terjadi..." required>{{ old('deskripsi') }}</textarea>

        <label>Foto Bukti (opsional, maks 2MB)</label>
        <input type="file" name="foto" accept="image/*">

        <button type="submit" class="btn-primary">Kirim Laporan</button>
    </form>
</div>

@include('partials.footer')
