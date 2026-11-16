<?php

namespace App\Http\Controllers\ERegulasi;

use App\Http\Controllers\Controller;
use App\Models\PartisipasiPublik;
use App\Models\Regulasi;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    public function store(Request $request, $id)
    {
        // $id di sini adalah regulasi_id (atau partisipasi_publik.id jika dikirim dari rute lama)
        $ujiPublikAktif = PartisipasiPublik::where('regulasi_id', $id)
            ->where('is_active', true)
            ->whereDate('tgl_selesai', '>=', now()->toDateString())
            ->first();

        if (!$ujiPublikAktif) {
            $byPpId = PartisipasiPublik::where('id', $id)
                ->where('is_active', true)
                ->whereDate('tgl_selesai', '>=', now()->toDateString())
                ->first();
            if ($byPpId) {
                $ujiPublikAktif = $byPpId;
                $id = $byPpId->regulasi_id;
            }
        }

        if (!$ujiPublikAktif) {
            return back()->with('error', 'Periode uji publik untuk rancangan regulasi ini sudah ditutup atau tidak aktif. Masukan baru tidak dapat dikirim.');
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'instansi' => 'required|in:masyarakat,pemerintahan_akademisi',
            'nama_instansi' => 'required_if:instansi,pemerintahan_akademisi|nullable|string|max:150',
            'nomor_telepon' => 'nullable|string|max:25',
            'isi_tanggapan' => 'required|string|min:10|max:5000',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'instansi.required' => 'Kategori pengirim wajib dipilih.',
            'nama_instansi.required_if' => 'Nama instansi/lembaga wajib diisi untuk kategori Pemerintahan/Akademisi.',
            'isi_tanggapan.required' => 'Isi masukan/tanggapan wajib diisi.',
            'isi_tanggapan.min' => 'Isi masukan minimal 10 karakter.',
        ]);

        Tanggapan::create([
            'regulasi_id' => $id,
            'user_id' => auth()->id() ?? null,
            'nama_pengirim' => strip_tags($request->nama),
            'email' => $request->email,
            'tipe' => $request->instansi,
            'nama_instansi' => $request->instansi === 'pemerintahan_akademisi' ? strip_tags($request->nama_instansi) : null,
            'nomor_telepon' => $request->nomor_telepon ? strip_tags($request->nomor_telepon) : null,
            'isi_tanggapan' => strip_tags($request->isi_tanggapan),
            'status_tindak_lanjut' => 'menunggu',
        ]);

        return back()->with('success', 'Masukan dan aspirasi Anda berhasil dikirim! Terima kasih atas partisipasi Anda dalam pembentukan peraturan perundang-undangan.');
    }

    /**
     * Admin/Operator memperbarui status proses, catatan internal, dan tindak lanjut masukan.
     */
    public function updateModeration(Request $request, $id)
    {
        $tanggapan = Tanggapan::findOrFail($id);

        $request->validate([
            'status_tindak_lanjut' => 'required|in:menunggu,ditelaah,diterima,ditolak',
            'catatan_internal' => 'nullable|string|max:3000',
            'tindak_lanjut' => 'nullable|string|max:3000',
        ]);

        $tanggapan->update([
            'status_tindak_lanjut' => $request->status_tindak_lanjut,
            'catatan_internal' => $request->catatan_internal,
            'tindak_lanjut' => $request->tindak_lanjut,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Status telaah dan tindak lanjut masukan berhasil diperbarui.');
    }

    /**
     * Admin/operator sembunyikan atau tampilkan kembali sebuah tanggapan dari publik.
     */
    public function toggleHide($id)
    {
        $tanggapan = Tanggapan::findOrFail($id);
        $tanggapan->update([
            'is_hidden' => !$tanggapan->is_hidden,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with(
            'success',
            $tanggapan->is_hidden ? 'Tanggapan disembunyikan dari tampilan publik.' : 'Tanggapan ditampilkan kembali ke halaman publik.'
        );
    }

    /**
     * Admin/operator hapus permanen sebuah tanggapan.
     */
    public function destroy($id)
    {
        $tanggapan = Tanggapan::findOrFail($id);
        $tanggapan->delete();

        return back()->with('success', 'Tanggapan berhasil dihapus.');
    }

    /**
     * Ekspor laporan masukan masyarakat ke CSV untuk suatu rancangan regulasi.
     */
    public function exportCsv($regulasiId)
    {
        $regulasi = Regulasi::with(['tanggapan.reviewer'])->findOrFail($regulasiId);

        $filename = 'Laporan_Partisipasi_Publik_Regulasi_' . $regulasi->id . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($regulasi) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'No',
                'Judul Rancangan Regulasi',
                'Unit Kerja',
                'Nama Pengirim',
                'Kategori Pengirim',
                'Nama Instansi',
                'Email Pengirim',
                'Nomor Telepon',
                'Isi Masukan / Tanggapan',
                'Status Proses',
                'Tindak Lanjut Tim Penyusun',
                'Catatan Internal Admin',
                'Visibilitas Publik',
                'Waktu Pengiriman',
                'Diperiksa Oleh',
                'Waktu Pemeriksaan',
            ], ',', '"', '\\');

            foreach ($regulasi->tanggapan as $idx => $t) {
                fputcsv($file, [
                    $idx + 1,
                    $regulasi->judul,
                    $regulasi->unit_kerja,
                    $t->nama_pengirim,
                    $t->label_instansi,
                    $t->nama_instansi ?: '-',
                    $t->email ?: '-',
                    $t->nomor_telepon ?: '-',
                    $t->isi_tanggapan,
                    $t->label_status,
                    $t->tindak_lanjut ?: '-',
                    $t->catatan_internal ?: '-',
                    $t->is_hidden ? 'Disembunyikan' : 'Ditampilkan',
                    $t->created_at ? $t->created_at->format('Y-m-d H:i:s') : '-',
                    $t->reviewer ? $t->reviewer->name : '-',
                    $t->reviewed_at ? $t->reviewed_at->format('Y-m-d H:i:s') : '-',
                ], ',', '"', '\\');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
