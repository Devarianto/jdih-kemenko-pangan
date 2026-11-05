<?php

namespace App\Http\Controllers\ERegulasi;

use App\Http\Controllers\Controller;
use App\Models\Regulasi;
use App\Models\RegulasiTahapan;
use App\Models\PartisipasiPublik;
use Illuminate\Http\Request;

class AdminPartisipasiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Regulasi::with(['partisipasiPublik', 'tanggapan'])
            ->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc');

        // Super Admin lihat semua, operator hanya unit kerjanya sendiri
        if ($user->role !== 'super_admin' && !empty($user->unit_kerja)) {
            $query->where('unit_kerja', $user->unit_kerja);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('unit_kerja', 'like', '%' . $search . '%')
                  ->orWhere('jenis', 'like', '%' . $search . '%');
            });
        }

        // Filter status — cocokkan dengan tahap current_stage (7 tahap)
        if ($request->filled('filter_status')) {
            $stage = $request->filter_status;

            if ($stage === 'selesai') {
                $query->where('status', 'selesai');
            } elseif ($stage === 'pasca_partisipasi') {
                $query->where('current_stage', 'uji_publik')
                    ->where('pasca_partisipasi_dimulai', true)
                    ->where('status', '!=', 'selesai');
            } elseif ($stage === 'uji_publik') {
                $query->where('current_stage', 'uji_publik')
                    ->where(function ($q) {
                        $q->whereNull('pasca_partisipasi_dimulai')->orWhere('pasca_partisipasi_dimulai', false);
                    })
                    ->where('status', '!=', 'selesai');
            } else {
                $query->where('current_stage', $stage)->where('status', '!=', 'selesai');
            }
        }

        // Filter jenis
        if ($request->filled('filter_jenis')) {
            $query->where('jenis', $request->filter_jenis);
        }

        $regulasi = $query->paginate(10)->withQueryString();
        return view('admin.partisipasi.index', compact('regulasi'));
    }

    public function show(Request $request, $id)
    {
        $regulasi = Regulasi::with(['partisipasiPublik', 'tanggapan.reviewer', 'tahapans'])
            ->findOrFail($id);

        return view('admin.partisipasi.show', compact('regulasi'));
    }

    public function setUjiPublik(Request $request, $id)
    {
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
        ]);

        $regulasi = Regulasi::findOrFail($id);

        PartisipasiPublik::updateOrCreate(
            ['regulasi_id' => $id],
            [
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'is_active' => true,
            ]
        );

        $regulasi->update([
            'status' => 'partisipasi_publik',
            'current_stage' => 'uji_publik',
            'uji_publik_status' => 'approved',
        ]);

        if (!$regulasi->tahapans()->where('stage', 'uji_publik')->exists()) {
            RegulasiTahapan::create([
                'regulasi_id' => $regulasi->id,
                'stage' => 'uji_publik',
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        }

        return back()->with('success', 'Periode Partisipasi Publik berhasil disimpan dan diaktifkan!');
    }

    /**
     * Super Admin menghentikan paksa (takedown) periode uji publik yang sedang aktif.
     */
    public function takedown($id)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Hanya Super Admin yang bisa menghentikan periode uji publik.');
        }

        $regulasi = Regulasi::with('partisipasiPublik')->findOrFail($id);

        if (!$regulasi->partisipasiPublik || !$regulasi->partisipasiPublik->is_active) {
            return back()->with('error', 'Tidak ada periode uji publik aktif untuk dihentikan.');
        }

        $regulasi->partisipasiPublik->update(['is_active' => false]);
        $regulasi->update(['status' => 'proses']);

        return redirect()->route('admin.partisipasi.index')
            ->with('success', "Periode uji publik untuk \"{$regulasi->judul}\" berhasil dihentikan (takedown).");
    }

    /**
     * Selesaikan periode Partisipasi Publik yang sedang berjalan.
     */
    public function selesaikan($id)
    {
        $regulasi = Regulasi::with('partisipasiPublik')->findOrFail($id);

        if (!$regulasi->partisipasiPublik || !$regulasi->partisipasiPublik->is_active) {
            return back()->with('error', 'Tidak ada periode uji publik aktif untuk diselesaikan.');
        }

        $regulasi->partisipasiPublik->update(['is_active' => false]);

        $regulasi->update([
            'pasca_partisipasi_dimulai' => true,
        ]);

        return redirect()->route('admin.partisipasi.index')
            ->with('success', "Periode Partisipasi Publik untuk \"{$regulasi->judul}\" berhasil diselesaikan. Regulasi lanjut ke tahap Pasca Partisipasi Publik.");
    }
}
