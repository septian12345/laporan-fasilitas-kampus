<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\KategoriFasilitas;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // GET /laporan - daftar laporan milik user login
    public function index()
    {
        $laporan = Laporan::where('user_id', auth()->id())
            ->with('kategori')
            ->latest()
            ->get();

        return view('laporan.index', compact('laporan'));
    }

    // GET /laporan/create - form buat laporan baru
    public function create()
    {
        $kategori = KategoriFasilitas::all();
        return view('laporan.create', compact('kategori'));
    }

    // POST /laporan - simpan laporan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_fasilitas_id' => 'required|exists:kategori_fasilitas,id',
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048', // maks 2MB
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'menunggu';

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('laporan-foto', 'public');
        }

        Laporan::create($validated);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dikirim.');
    }

    // GET /laporan/{laporan} - detail + riwayat progres
    public function show(Laporan $laporan)
    {
        // Hanya pemilik laporan atau petugas/admin yang boleh lihat
        if ($laporan->user_id !== auth()->id() && !auth()->user()->isAdminOrPetugas()) {
            abort(403);
        }

        $laporan->load('progres.petugas', 'kategori');

        return view('laporan.show', compact('laporan'));
    }
}
