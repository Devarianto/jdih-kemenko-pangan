<?php

namespace App\Http\Controllers\ERegulasi;

use App\Http\Controllers\Controller;
use App\Models\PartisipasiPublik;
use App\Models\Regulasi;
use Cactuar\Admin\Models\Menu;
use Illuminate\Http\Request;

class PartisipasiPublikController extends Controller
{
    /**
     * Query helper: ambil semua partisipasi publik (aktif maupun sudah berakhir),
     * lengkap dengan relasi regulasi dan tanggapan.
     * Sekaligus auto-deactivate record yang periodenya sudah habis, serta
     * memastikan setiap regulasi di tahap uji_publik memiliki record PartisipasiPublik.
     */
    private function queryAll(Request $request = null)
    {
        // Auto-sync: jika ada regulasi dengan status 'partisipasi_publik' / stage 'uji_publik'
        // yang belum memiliki record di tabel partisipasi_publik, buatkan otomatis agar tidak terlewat.
        $unsynced = Regulasi::where(function ($q) {
                $q->where('status', 'partisipasi_publik')
                  ->orWhere('current_stage', 'uji_publik');
            })
            ->whereDoesntHave('partisipasiPublik')
            ->get();

        foreach ($unsynced as $reg) {
            PartisipasiPublik::create([
                'regulasi_id' => $reg->id,
                'tgl_mulai' => $reg->tgl_usulan ?: now()->subDays(3)->toDateString(),
                'tgl_selesai' => now()->addDays(14)->toDateString(),
                'is_active' => !$reg->pasca_partisipasi_dimulai && $reg->status !== 'selesai',
            ]);
        }

        // Auto-deactivate yang sudah kedaluwarsa
        PartisipasiPublik::where('is_active', true)
            ->where('tgl_selesai', '<', now()->startOfDay())
            ->update(['is_active' => false]);

        $query = PartisipasiPublik::with(['regulasi', 'regulasi.tanggapan'])
            ->whereHas('regulasi')
            ->orderByDesc('is_active')
            ->orderByDesc('updated_at')
            ->orderByDesc('id');

        if ($request) {
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('regulasi', function ($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%')
                      ->orWhere('abstrak', 'like', '%' . $search . '%')
                      ->orWhere('unit_kerja', 'like', '%' . $search . '%')
                      ->orWhere('jenis', 'like', '%' . $search . '%');
                });
            }

            if ($request->filled('status')) {
                if ($request->status === 'aktif') {
                    $query->where('is_active', true)->whereDate('tgl_selesai', '>=', now()->toDateString());
                } elseif ($request->status === 'berakhir') {
                    $query->where(function ($q) {
                        $q->where('is_active', false)->orWhereDate('tgl_selesai', '<', now()->toDateString());
                    });
                }
            }

            if ($request->filled('jenis')) {
                $jenis = $request->jenis;
                $query->whereHas('regulasi', function ($q) use ($jenis) {
                    $q->where('jenis', $jenis);
                });
            }
        }

        return $query;
    }

    protected function resolvePublicMenu($menu = null)
    {
        if ($menu) {
            return $menu;
        }
        return Menu::find(35)
            ?? Menu::fe()->whereIsActive(1)->where('type', 'rancangan-puu')->first()
            ?? Menu::first();
    }

    /**
     * Memeriksa apakah fitur Partisipasi Publik aktif di web publik.
     * Jika menu 35 dinonaktifkan (is_active = 0), fitur dianggap mati.
     */
    public static function isEnabled(): bool
    {
        return (bool) \Illuminate\Support\Facades\DB::table('menus')
            ->where('id', 35)
            ->where('is_active', 1)
            ->exists();
    }

    public function beranda()
    {
        if (!self::isEnabled()) {
            abort(404);
        }

        $preview = $this->queryAll()
            ->take(3)
            ->get();

        return view('beranda', compact('preview'));
    }

    public function index(Request $request, $menu = null)
    {
        if (!self::isEnabled()) {
            abort(404);
        }

        $menu = $this->resolvePublicMenu($menu);

        $daftarUjiPublik = $this->queryAll($request)
            ->paginate(9)
            ->withQueryString();

        return view('partisipasi-publik.index', compact('daftarUjiPublik', 'menu'));
    }

    public function show($id)
    {
        if (!self::isEnabled()) {
            abort(404);
        }

        $menu = $this->resolvePublicMenu();

        $ujiPublik = PartisipasiPublik::with(['regulasi', 'regulasi.tanggapan.user', 'regulasi.tanggapan.reviewer'])
            ->where('id', $id)
            ->orWhere('regulasi_id', $id)
            ->firstOrFail();

        return view('partisipasi-publik.show', compact('ujiPublik', 'menu'));
    }
}
