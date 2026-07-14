<?php
namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\ProgresLaporan;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    // GET /admin/dashboard - semua laporan masuk + filter status
    public function index(Request $request)
    {
        $filter = $request->query('status', 'semua');

        $query = Laporan::with('user', 'kategori')->latest();

        if ($filter !== 'semua') {
            $query->where('status', $filter);
        }

        $laporan = $query->get();

        $stats = [
            'total' => Laporan::count(),
            'menunggu' => Laporan::where('status', 'menunggu')->count(),
            'diproses' => Laporan::where('status', 'diproses')->count(),
            'selesai' => Laporan::where('status', 'selesai')->count(),
        ];

        return view('admin.dashboard', compact('laporan', 'stats', 'filter'));
    }

    // POST /admin/laporan/{laporan}/update-status
    public function updateStatus(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'status_baru' => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $laporan->update(['status' => $validated['status_baru']]);

        ProgresLaporan::create([
            'laporan_id' => $laporan->id,
            'diubah_oleh' => auth()->id(),
            'status_baru' => $validated['status_baru'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return back()->with('success', 'Status laporan diperbarui.');
    }
}