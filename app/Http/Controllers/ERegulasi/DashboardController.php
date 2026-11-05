<?php

namespace App\Http\Controllers\ERegulasi;

use App\Http\Controllers\Controller;

use App\Models\Regulasi;
use App\Models\Tanggapan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'super_admin') {
            return $this->superAdminDashboard();
        }

        return $this->operatorDashboard($user);
    }

    private function superAdminDashboard()
    {
        $stats = [
            'total_rancangan' => Regulasi::count(),
            'total_selesai' => Regulasi::where('status', 'penetapan')->orWhere('status', 'selesai')->count(),
            'total_proses' => Regulasi::whereIn('status', ['proses', 'partisipasi_publik'])->count(),
            'total_tanggapan' => Tanggapan::count(),
            'masukan_masyarakat' => Tanggapan::where('tipe', 'masyarakat')->count(),
            'masukan_instansi' => Tanggapan::where('tipe', 'instansi')->count(),
        ];

        $tahapan = Regulasi::selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->get();

        $pendingUjiPublik = Regulasi::with('pemohon')
            ->where('uji_publik_status', 'requested')
            ->latest()
            ->get();

        $perUnitKerja = Regulasi::selectRaw('unit_kerja, count(*) as jumlah')
            ->groupBy('unit_kerja')
            ->orderByDesc('jumlah')
            ->get();

        // Ambil semua regulasi terbaru (bukan cuma 5) agar filter JS bisa jalan lintas status
        $regulasiTerbaru = Regulasi::with('pemohon')
            ->latest()
            ->get();

        return view('dashboard', compact(
            'stats',
            'tahapan',
            'pendingUjiPublik',
            'perUnitKerja',
            'regulasiTerbaru'
        ));
    }

    private function operatorDashboard($user)
    {
        $stats = [
            'total_rancangan' => Regulasi::where('unit_kerja', $user->unit_kerja)->count(),
            'total_selesai' => Regulasi::where('unit_kerja', $user->unit_kerja)
                ->whereIn('status', ['penetapan', 'selesai'])->count(),
            'total_proses' => Regulasi::where('unit_kerja', $user->unit_kerja)
                ->whereIn('status', ['proses', 'partisipasi_publik'])->count(),
            'total_tanggapan' => Tanggapan::whereHas(
                'regulasi',
                fn($q) =>
                $q->where('unit_kerja', $user->unit_kerja)
            )->count(),
        ];

        $tahapan = Regulasi::selectRaw('status, count(*) as jumlah')
            ->where('unit_kerja', $user->unit_kerja)
            ->groupBy('status')
            ->get();

        $pendingUjiPublik = Regulasi::where('unit_kerja', $user->unit_kerja)
            ->where('uji_publik_status', 'requested')
            ->get();

        $rejectedUjiPublik = Regulasi::where('unit_kerja', $user->unit_kerja)
            ->where('uji_publik_status', 'rejected')
            ->get();

        $approvedThisMonth = Regulasi::where('unit_kerja', $user->unit_kerja)
            ->where('uji_publik_status', 'approved')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        // Ambil semua regulasi unit kerja ini agar filter JS bisa jalan lintas status
        $regulasiTerbaru = Regulasi::where('unit_kerja', $user->unit_kerja)
            ->latest()
            ->get();

        return view('dashboard', compact(
            'stats',
            'tahapan',
            'pendingUjiPublik',
            'rejectedUjiPublik',
            'approvedThisMonth',
            'regulasiTerbaru'
        ));
    }
}
