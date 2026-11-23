<?php

namespace App\Http\Controllers\ERegulasi;

use App\Http\Controllers\Controller;

use App\Models\Regulasi;
use App\Models\RegulasiProses;
use App\Models\RegulasiTahapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegulasiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Regulasi::orderByRaw('COALESCE(tgl_usulan, DATE(created_at)) DESC')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');

        // Super Admin melihat regulasi dari SEMUA unit kerja.
        // Operator hanya melihat regulasi unit kerjanya sendiri.
        if ($user->role !== 'super_admin') {
            $query->where('unit_kerja', $user->unit_kerja);
        }

        if ($request->filled('filter_status')) {
            if ($request->filter_status === 'selesai') {
                // Selesai pakai kolom status karena current_stage tetap 'penetapan'
                $query->where('status', 'selesai');
            } elseif ($request->filter_status === 'pasca_partisipasi') {
                // Pasca partisipasi: current_stage masih uji_publik tapi flag sudah dimulai
                $query->where('current_stage', 'uji_publik')
                    ->where('pasca_partisipasi_dimulai', true);
            } else {
                $query->where('current_stage', $request->filter_status);
            }
        }

        if ($request->filled('filter_jenis')) {
            $query->where('jenis', $request->filter_jenis);
        }

        $regulasi = $query->paginate(10)->withQueryString();

        return view('regulasi.index', compact('regulasi'));
    }

    /**
     * Khusus operator: lihat regulasi milik UNIT KERJA LAIN, read-only (tanpa Hapus/CRUD).
     * Super Admin tidak butuh halaman ini karena sudah lihat semua di index().
     */
    public function indexLainnya(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'super_admin') {
            return redirect()->route('regulasi.index');
        }

        $query = Regulasi::where('unit_kerja', '!=', $user->unit_kerja)
            ->orderByRaw('COALESCE(tgl_usulan, DATE(created_at)) DESC')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');

        if ($request->filled('filter_status')) {
            if ($request->filter_status === 'selesai') {
                $query->where('status', 'selesai');
            } elseif ($request->filter_status === 'pasca_partisipasi') {
                $query->where('current_stage', 'uji_publik')
                    ->where('pasca_partisipasi_dimulai', true);
            } else {
                $query->where('current_stage', $request->filter_status);
            }
        }

        if ($request->filled('filter_jenis')) {
            $query->where('jenis', $request->filter_jenis);
        }

        $regulasi = $query->paginate(10)->withQueryString();

        return view('regulasi.index-lainnya', compact('regulasi'));
    }

    public function create()
    {
        return view('regulasi.create');
    }

    public function store(Request $request)
    {
        $isSuperAdmin = auth()->user()->role === 'super_admin';

        $request->validate([
            'jenis' => 'required',
            'judul' => 'required|string|max:500',
            'abstrak' => 'required|string|max:2000',
            'tgl_usulan' => 'required|date',
            'unit_kerja' => 'nullable|string|max:255',
            'file_permohonan' => [$isSuperAdmin ? 'nullable' : 'required', 'file', 'mimes:pdf', 'max:10240'],
            'file_draft' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'file_permohonan.required' => 'Dokumen Permohonan wajib diunggah.',
            'file_permohonan.mimes' => 'Dokumen Permohonan harus berformat PDF.',
            'file_permohonan.max' => 'Ukuran Dokumen Permohonan tidak boleh lebih dari 10 MB.',
            'file_draft.required' => 'Draft Awal Rancangan wajib diunggah.',
            'file_draft.mimes' => 'Draft Awal Rancangan harus berformat PDF, DOC, atau DOCX.',
            'file_draft.max' => 'Ukuran Draft Awal Rancangan tidak boleh lebih dari 10 MB.',
        ]);

        $data = $request->only(['jenis', 'judul', 'abstrak', 'tgl_usulan']);
        $data['unit_kerja'] = auth()->user()->unit_kerja ?: ($request->input('unit_kerja') ?: 'Biro Hukum dan Kerja Sama');
        $data['created_by'] = auth()->id();
        $data['status'] = 'proses';
        $data['current_stage'] = 'pembahasan';

        if ($request->hasFile('file_permohonan')) {
            $data['file_permohonan'] = $request->file('file_permohonan')->store('regulasi/permohonan', 'public');
        }
        if ($request->hasFile('file_draft')) {
            $data['file_draft'] = $request->file('file_draft')->store('regulasi/draft', 'public');
        }

        $regulasi = Regulasi::create($data);

        // Pengajuan selesai otomatis dan langsung memasuki tahap Pembahasan tanpa perlu ACC Super Admin
        RegulasiTahapan::create([
            'regulasi_id' => $regulasi->id,
            'stage' => 'pengajuan',
            'status' => 'completed',
            'started_at' => now(),
            'completed_at' => now(),
        ]);

        RegulasiTahapan::create([
            'regulasi_id' => $regulasi->id,
            'stage' => 'pembahasan',
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Regulasi berhasil diajukan dan langsung memasuki tahap Pembahasan.')
            ->withFragment('tahap-pembahasan');
    }

    /**
     * Form edit data rancangan.
     * Operator hanya dapat mengedit di tahap Pengajuan/Pembahasan; Super Admin dapat
     * memperbarui data kapan saja termasuk setelah melewati tahap Partisipasi Publik.
     */
    public function edit(Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        $isSuperAdmin = auth()->user()->role === 'super_admin';
        if (!$isSuperAdmin && !in_array($regulasi->current_stage, ['pengajuan', 'pembahasan'])) {
            return redirect()->route('regulasi.show', $regulasi)
                ->with('error', 'Data pengajuan tidak dapat diubah lagi karena sudah melewati tahap Pembahasan.');
        }

        return view('regulasi.edit', compact('regulasi'));
    }

    /**
     * Simpan perubahan data rancangan. File lama dipertahankan jika tidak
     * ada file baru yang diupload.
     */
    public function update(Request $request, Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        $isSuperAdmin = auth()->user()->role === 'super_admin';
        if (!$isSuperAdmin && !in_array($regulasi->current_stage, ['pengajuan', 'pembahasan'])) {
            return redirect()->route('regulasi.show', $regulasi)
                ->with('error', 'Data pengajuan tidak dapat diubah lagi karena sudah melewati tahap Pembahasan.');
        }

        $request->validate([
            'jenis' => 'required',
            'judul' => 'required|string|max:500',
            'abstrak' => 'nullable|string|max:2000',
            'unit_kerja' => 'nullable|string|max:255',
            'tgl_usulan' => 'required|date',
            'file_permohonan' => [$isSuperAdmin || $regulasi->file_permohonan ? 'nullable' : 'required', 'file', 'mimes:pdf', 'max:10240'],
            'file_draft' => [$regulasi->file_draft ? 'nullable' : 'required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ], [
            'file_permohonan.required' => 'Dokumen Permohonan wajib diunggah.',
            'file_permohonan.mimes' => 'Dokumen Permohonan harus berformat PDF.',
            'file_permohonan.max' => 'Ukuran Dokumen Permohonan tidak boleh lebih dari 10 MB.',
            'file_draft.required' => 'Draft Awal Rancangan wajib diunggah.',
            'file_draft.mimes' => 'Draft Awal Rancangan harus berformat PDF, DOC, atau DOCX.',
            'file_draft.max' => 'Ukuran Draft Awal Rancangan tidak boleh lebih dari 10 MB.',
        ]);

        $data = $request->only(['jenis', 'judul', 'tgl_usulan']);
        if ($request->filled('abstrak')) {
            $data['abstrak'] = $request->abstrak;
        }
        if ($isSuperAdmin && $request->filled('unit_kerja')) {
            $data['unit_kerja'] = $request->unit_kerja;
        }

        if ($request->hasFile('file_permohonan')) {
            if ($regulasi->file_permohonan) {
                Storage::disk('public')->delete($regulasi->file_permohonan);
            }
            $data['file_permohonan'] = $request->file('file_permohonan')->store('regulasi/permohonan', 'public');
        }

        if ($request->hasFile('file_draft')) {
            if ($regulasi->file_draft) {
                Storage::disk('public')->delete($regulasi->file_draft);
            }
            $data['file_draft'] = $request->file('file_draft')->store('regulasi/draft', 'public');
        }

        $regulasi->update($data);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Data rancangan regulasi berhasil diperbarui.')
            ->withFragment('tahap-pengajuan');
    }

    /**
     * Operator mengklik "Mulai Pembahasan" untuk memindahkan regulasi
     * dari tahap Pengajuan ke tahap Pembahasan secara manual.
     */
    public function mulaiPembahasan(Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        if ($regulasi->current_stage !== 'pengajuan') {
            return back()->with('error', 'Regulasi ini sudah tidak berada di tahap Pengajuan.');
        }

        $regulasi->update([
            'current_stage' => 'pembahasan',
            'status' => 'proses',
        ]);

        RegulasiTahapan::create([
            'regulasi_id' => $regulasi->id,
            'stage' => 'pembahasan',
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Tahap Pembahasan dimulai.')
            ->withFragment('tahap-pembahasan');
    }

    public function show(Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        $regulasi->load(['tahapans', 'proses', 'pemohon', 'partisipasiPublik']);

        // Eager load tanggapan beserta user-nya untuk ditampilkan di pane uji publik
        $regulasi->load(['tanggapan.user']);

        // Auto-transisi: kalau masih di Uji Publik tapi periodenya sudah lewat tanggal
        // selesai, otomatis majukan ke Harmonisasi tanpa perlu aksi manual.
        if ($regulasi->isUjiPublikKedaluwarsa()) {
            $regulasi->tahapans()
                ->where('stage', 'uji_publik')
                ->whereNull('completed_at')
                ->update(['status' => 'completed', 'completed_at' => now()]);

            $regulasi->update([
                'current_stage' => 'harmonisasi',
                'status' => 'penetapan',
            ]);

            // Nonaktifkan periode partisipasi publik supaya hilang dari halaman publik.
            $regulasi->partisipasiPublik?->update(['is_active' => false]);

            RegulasiTahapan::create([
                'regulasi_id' => $regulasi->id,
                'stage' => 'harmonisasi',
                'status' => 'in_progress',
                'started_at' => now(),
                'notes' => 'Otomatis dimulai karena periode Uji Publik telah berakhir.',
            ]);

            $regulasi->refresh();
        }

        // Gunakan relasi tanggapan yang sudah di-eager load
        $komentarPublik = $regulasi->tanggapan ?? collect();

        return view('regulasi.show', compact('regulasi', 'komentarPublik'));
    }

    public function destroy(Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        $publicFiles = $regulasi->collectPublicStorageFiles();

        DB::transaction(function () use ($regulasi) {
            $regulasi->delete();
        });

        foreach ($publicFiles as $path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()->route('regulasi.index')->with('success', 'Regulasi dan seluruh berkas terkait berhasil dihapus.');
    }

    /**
     * Operator menambah baris baru di tabel proses pembahasan.
     * Mendukung multiple file upload.
     */
    public function tambahProses(Request $request, Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        if ($regulasi->current_stage === 'pengajuan') {
            $regulasi->update([
                'current_stage' => 'pembahasan',
                'status' => 'proses',
            ]);

            if (!$regulasi->tahapans()->where('stage', 'pembahasan')->exists()) {
                RegulasiTahapan::create([
                    'regulasi_id' => $regulasi->id,
                    'stage' => 'pembahasan',
                    'status' => 'in_progress',
                    'started_at' => now(),
                ]);
            }
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'proses' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file_dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:1024',
        ], [
            'file_dokumen.*.max' => 'Ukuran setiap file tidak boleh lebih dari 1 MB.',
            'file_dokumen.*.mimes' => 'File harus berformat PDF, Word, Excel, atau PowerPoint.',
        ]);

        // force_pasca = dari form Pasca Partisipasi Publik, selalu ditandai is_after_uji_publik
        $forcePasca = $request->boolean('force_pasca');
        $sudahPernahUjiPublik = $forcePasca || $regulasi->tahapans()
            ->where('stage', 'uji_publik')
            ->exists();

        $filePaths = [];
        if ($request->hasFile('file_dokumen')) {
            foreach ($request->file('file_dokumen') as $file) {
                $filePaths[] = $file->store('proses-dokumen', 'public');
            }
        }

        RegulasiProses::create([
            'regulasi_id' => $regulasi->id,
            'judul' => $request->judul,
            'proses' => $request->proses,
            'tanggal' => $request->tanggal,
            'file_dokumen' => !empty($filePaths) ? $filePaths : null,
            'is_after_uji_publik' => $sudahPernahUjiPublik,
            'created_by' => auth()->id(),
        ]);

        $regulasi->touch();

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', $forcePasca
                ? 'Proses pasca partisipasi publik berhasil ditambahkan.'
                : 'Proses pembahasan berhasil ditambahkan.')
            ->withFragment($forcePasca ? 'tahap-pasca_partisipasi' : 'tahap-pembahasan');
    }

    /**
     * Update data proses pembahasan.
     * File lama dipertahankan jika tidak ada file baru yang diupload.
     */
    public function updateProses(Request $request, Regulasi $regulasi, RegulasiProses $proses)
    {
        $this->authorizeUnitKerja($regulasi);

        $request->validate([
            'judul' => 'required|string|max:255',
            'proses' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file_dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:1024',
        ], [
            'file_dokumen.*.max' => 'Ukuran setiap file tidak boleh lebih dari 1 MB.',
            'file_dokumen.*.mimes' => 'File harus berformat PDF, Word, Excel, atau PowerPoint.',
        ]);

        $data = $request->only(['judul', 'proses', 'tanggal']);

        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama
            if (!empty($proses->file_dokumen)) {
                foreach ((array) $proses->file_dokumen as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
            $filePaths = [];
            foreach ($request->file('file_dokumen') as $file) {
                $filePaths[] = $file->store('proses-dokumen', 'public');
            }
            $data['file_dokumen'] = $filePaths;
        }

        $proses->update($data);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', $proses->is_after_uji_publik
                ? 'Proses pasca partisipasi publik berhasil diperbarui.'
                : 'Proses pembahasan berhasil diperbarui.')
            ->withFragment($proses->is_after_uji_publik ? 'tahap-pasca_partisipasi' : 'tahap-pembahasan');
    }

    /**
     * Hapus satu baris proses pembahasan beserta file-nya.
     */
    public function destroyProses(Regulasi $regulasi, RegulasiProses $proses)
    {
        $this->authorizeUnitKerja($regulasi);

        $isAfterUjiPublik = $proses->is_after_uji_publik;

        if (!empty($proses->file_dokumen)) {
            foreach ((array) $proses->file_dokumen as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $proses->delete();

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', $isAfterUjiPublik
                ? 'Proses pasca partisipasi publik berhasil dihapus.'
                : 'Proses pembahasan berhasil dihapus.')
            ->withFragment($isAfterUjiPublik ? 'tahap-pasca_partisipasi' : 'tahap-pembahasan');
    }

    /**
     * Operator request maju ke tahap Uji Publik, sekaligus mengusulkan
     * periode tanggal mulai & selesai partisipasi publik. Data periode
     * langsung disimpan ke tabel partisipasi_publik (is_active = false)
     * supaya operator tidak lupa mengisinya nanti di halaman terpisah.
     */
    public function requestUjiPublik(Request $request, Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        if ($regulasi->current_stage !== 'pembahasan') {
            return back()->with('error', 'Request uji publik hanya bisa dilakukan saat regulasi di tahap Pembahasan.');
        }

        if ($regulasi->proses()->count() === 0) {
            return back()->with('error', 'Tambahkan minimal satu proses pembahasan sebelum request uji publik.');
        }

        $request->validate([
            'tgl_mulai_uji_publik' => 'required|date|after_or_equal:today',
            'tgl_selesai_uji_publik' => 'required|date|after:tgl_mulai_uji_publik',
        ], [
            'tgl_mulai_uji_publik.required' => 'Tanggal mulai partisipasi publik wajib diisi.',
            'tgl_selesai_uji_publik.required' => 'Tanggal selesai partisipasi publik wajib diisi.',
            'tgl_selesai_uji_publik.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        \App\Models\PartisipasiPublik::updateOrCreate(
            ['regulasi_id' => $regulasi->id],
            [
                'tgl_mulai' => $request->tgl_mulai_uji_publik,
                'tgl_selesai' => $request->tgl_selesai_uji_publik,
                'is_active' => false, // diaktifkan otomatis saat Super Admin approve
            ]
        );

        $regulasi->update(['uji_publik_status' => 'requested']);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Request uji publik berhasil dikirim beserta periode tanggal, menunggu persetujuan Super Admin.')
            ->withFragment('tahap-uji_publik');
    }

    /**
     * Super Admin menyetujui request uji publik.
     * Periode tanggal sudah diisi operator saat request, jadi di sini
     * cukup mengaktifkan record partisipasi_publik yang sudah ada.
     */
    public function approveUjiPublik(Regulasi $regulasi)
    {
        $this->authorizeSuperAdmin();

        if ($regulasi->uji_publik_status !== 'requested') {
            return back()->with('error', 'Tidak ada request uji publik yang menunggu persetujuan.');
        }

        // Tutup tahap pembahasan
        $regulasi->tahapans()
            ->where('stage', 'pembahasan')
            ->whereNull('completed_at')
            ->update(['status' => 'completed', 'completed_at' => now()]);

        $regulasi->update([
            'current_stage' => 'uji_publik',
            'uji_publik_status' => 'approved',
            'status' => 'partisipasi_publik',
        ]);

        // Aktifkan periode partisipasi publik yang sudah diusulkan operator
        $regulasi->partisipasiPublik?->update(['is_active' => true]);

        RegulasiTahapan::create([
            'regulasi_id' => $regulasi->id,
            'stage' => 'uji_publik',
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Uji publik disetujui dan dimulai.')
            ->withFragment('tahap-uji_publik');
    }

    /**
     * Super Admin menolak request uji publik. Regulasi tetap di Pembahasan.
     */
    public function rejectUjiPublik(Request $request, Regulasi $regulasi)
    {
        $this->authorizeSuperAdmin();

        if ($regulasi->uji_publik_status !== 'requested') {
            return back()->with('error', 'Tidak ada request uji publik yang menunggu persetujuan.');
        }

        $regulasi->update(['uji_publik_status' => 'rejected']);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Request uji publik ditolak.')
            ->withFragment('tahap-pembahasan');
    }

    /**
     * Khusus Super Admin: mengubah (memajukan atau memundurkan) tanggal periode
     * Partisipasi Publik langsung dari timeline detail regulasi.
     */
    public function updatePeriodeUjiPublik(Request $request, Regulasi $regulasi)
    {
        $this->authorizeSuperAdmin();

        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
        ], [
            'tgl_mulai.required' => 'Tanggal mulai partisipasi publik wajib diisi.',
            'tgl_selesai.required' => 'Tanggal selesai partisipasi publik wajib diisi.',
            'tgl_selesai.after' => 'Tanggal selesai harus lebih besar dari tanggal mulai.',
        ]);

        $isPeriodActive = \Carbon\Carbon::parse($request->tgl_selesai)->endOfDay()->gte(now());

        \App\Models\PartisipasiPublik::updateOrCreate(
            ['regulasi_id' => $regulasi->id],
            [
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'is_active' => $isPeriodActive,
            ]
        );

        $updateData = ['uji_publik_status' => 'approved'];
        if ($isPeriodActive) {
            if (in_array($regulasi->current_stage, ['pengajuan', 'pembahasan'])) {
                $updateData['current_stage'] = 'uji_publik';
            }
            if ($regulasi->current_stage === 'uji_publik' || in_array($regulasi->current_stage, ['pengajuan', 'pembahasan'])) {
                $updateData['status'] = 'partisipasi_publik';
            }
        } else {
            if ($regulasi->current_stage === 'uji_publik' && $regulasi->status === 'partisipasi_publik') {
                $updateData['status'] = 'proses';
            }
        }
        $regulasi->update($updateData);

        $tahapan = $regulasi->tahapans()->where('stage', 'uji_publik')->first();
        $tahapanData = [
            'status' => $isPeriodActive ? 'in_progress' : 'completed',
            'started_at' => $request->tgl_mulai . ' 09:00:00',
            'completed_at' => $isPeriodActive ? null : ($request->tgl_selesai . ' 17:00:00'),
        ];
        if ($tahapan) {
            $tahapan->update($tahapanData);
        } else {
            RegulasiTahapan::create(array_merge(['regulasi_id' => $regulasi->id, 'stage' => 'uji_publik'], $tahapanData));
        }

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', $isPeriodActive
                ? 'Tanggal periode Partisipasi Publik berhasil diperbarui dan statusnya dibuka.'
                : 'Tanggal periode Partisipasi Publik berhasil diperbarui (status ditutup karena tanggal selesai telah lewat).')
            ->withFragment('tahap-uji_publik');
    }

    /**
     * Mengembalikan regulasi dari Uji Publik ke Pembahasan.
     */
    public function kembalikanKePembahasan(Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        if ($regulasi->current_stage !== 'uji_publik') {
            return back()->with('error', 'Hanya regulasi di tahap Uji Publik yang bisa dikembalikan.');
        }

        $regulasi->tahapans()
            ->where('stage', 'uji_publik')
            ->whereNull('completed_at')
            ->update(['status' => 'reverted', 'completed_at' => now()]);

        $regulasi->update([
            'current_stage' => 'pembahasan',
            'uji_publik_status' => null,
            'status' => 'proses',
        ]);

        RegulasiTahapan::create([
            'regulasi_id' => $regulasi->id,
            'stage' => 'pembahasan',
            'status' => 'in_progress',
            'started_at' => now(),
            'notes' => 'Dikembalikan dari tahap Uji Publik.',
        ]);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Regulasi dikembalikan ke tahap Pembahasan.')
            ->withFragment('tahap-pembahasan');
    }

    /**
     * Lanjutkan dari Uji Publik ke tab Pasca Partisipasi Publik.
     * current_stage TETAP 'uji_publik' — pasca partisipasi berjalan paralel
     * di dalam periode uji publik, sebelum harmonisasi dimulai.
     */
    public function lanjutPascaPartisipasi(Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        if ($regulasi->current_stage !== 'uji_publik') {
            return back()->with('error', 'Lanjut ke Pasca Partisipasi hanya bisa dilakukan saat regulasi di tahap Uji Publik.');
        }

        // Tandai bahwa operator sudah resmi membuka tahap Pasca Partisipasi.
        // current_stage TETAP 'uji_publik' — flag ini yang membuka kunci pane
        // Pasca Partisipasi, bukan current_stage.
        $regulasi->update(['pasca_partisipasi_dimulai' => true]);

        // Nonaktifkan periode partisipasi publik supaya regulasi ini hilang dari
        // listing publik (beranda & index) begitu masuk tahap Pasca Partisipasi.
        $regulasi->partisipasiPublik?->update(['is_active' => false]);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Silakan isi proses Pasca Partisipasi Publik.')
            ->withFragment('tahap-pasca_partisipasi');
    }

    /**
     * Manual override: langsung mulai tahap Harmonisasi dari Uji Publik,
     * tanpa menunggu periode partisipasi publik berakhir.
     */
    public function mulaiHarmonisasi(Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        if ($regulasi->current_stage !== 'uji_publik') {
            return back()->with('error', 'Hanya regulasi di tahap Uji Publik yang bisa dimajukan ke Harmonisasi.');
        }

        $regulasi->tahapans()
            ->where('stage', 'uji_publik')
            ->whereNull('completed_at')
            ->update(['status' => 'completed', 'completed_at' => now()]);

        $regulasi->update([
            'current_stage' => 'harmonisasi',
            'status' => 'penetapan',
        ]);

        // Nonaktifkan periode partisipasi publik supaya hilang dari halaman publik.
        $regulasi->partisipasiPublik?->update(['is_active' => false]);

        RegulasiTahapan::create([
            'regulasi_id' => $regulasi->id,
            'stage' => 'harmonisasi',
            'status' => 'in_progress',
            'started_at' => now(),
            'notes' => 'Dimulai manual sebelum periode Uji Publik berakhir.',
        ]);

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Tahap Harmonisasi dimulai.')
            ->withFragment('tahap-harmonisasi');
    }

    /**
     * Update tahap Harmonisasi (tanggal + dokumen wajib).
     * Catatan dihapus dari tahap ini.
     */
    public function updateHarmonisasi(Request $request, Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        $request->validate([
            'tgl_mulai_harmonisasi' => 'required|date',
            'tgl_selesai_harmonisasi' => 'nullable|date|after_or_equal:tgl_mulai_harmonisasi',
            'harmon_surat_permohonan' => 'nullable|file|mimes:pdf,doc,docx|max:1024',
            'harmon_naskah_urgensi' => 'nullable|file|mimes:pdf,doc,docx|max:1024',
            'harmon_draft_rancangan' => 'nullable|file|mimes:pdf,doc,docx|max:1024',
        ], [
            'harmon_surat_permohonan.max' => 'Ukuran file tidak boleh lebih dari 1 MB.',
            'harmon_surat_permohonan.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
            'harmon_naskah_urgensi.max' => 'Ukuran file tidak boleh lebih dari 1 MB.',
            'harmon_naskah_urgensi.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
            'harmon_draft_rancangan.max' => 'Ukuran file tidak boleh lebih dari 1 MB.',
            'harmon_draft_rancangan.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
        ]);

        // Validasi manual: setiap file wajib ada (upload baru ATAU sudah tersimpan di DB)
        $dokumenHarmon = ['harmon_surat_permohonan', 'harmon_naskah_urgensi', 'harmon_draft_rancangan'];
        foreach ($dokumenHarmon as $field) {
            if (!$regulasi->$field && !$request->hasFile($field)) {
                return back()
                    ->withErrors([$field => 'File ini wajib diupload.'])
                    ->withInput();
            }
        }

        $data = $request->only(['tgl_mulai_harmonisasi', 'tgl_selesai_harmonisasi']);
        // catatan_harmonisasi TIDAK disimpan (dihapus dari fitur)

        foreach ($dokumenHarmon as $field) {
            if ($request->hasFile($field)) {
                if ($regulasi->$field)
                    Storage::disk('public')->delete($regulasi->$field);
                $data[$field] = $request->file($field)->store('harmonisasi-dokumen', 'public');
            }
        }

        $regulasi->update($data);

        // Jika masih di uji_publik, majukan ke harmonisasi
        if ($regulasi->current_stage === 'uji_publik') {
            $regulasi->tahapans()
                ->where('stage', 'uji_publik')
                ->whereNull('completed_at')
                ->update(['status' => 'completed', 'completed_at' => now()]);

            $regulasi->partisipasiPublik?->update(['is_active' => false]);

            $regulasi->update(['current_stage' => 'harmonisasi', 'status' => 'penetapan']);

            RegulasiTahapan::create([
                'regulasi_id' => $regulasi->id,
                'stage' => 'harmonisasi',
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        }

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Data harmonisasi diperbarui.')
            ->withFragment('tahap-harmonisasi');
    }

    /**
     * Update tahap Penetapan (tanggal, catatan, + dokumen wajib).
     */
    public function updatePenetapan(Request $request, Regulasi $regulasi)
    {
        $this->authorizeUnitKerja($regulasi);

        $request->validate([
            'tgl_mulai_penetapan' => 'required|date',
            'tgl_selesai_penetapan' => 'nullable|date|after_or_equal:tgl_mulai_penetapan',
            'catatan_penetapan' => 'nullable|string',
            'tapan_surat_permohonan' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'tapan_surat_selesai_harmon' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'tapan_ba_harmon' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'tapan_softcopy_harmon' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'tapan_draft_akhir' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // Validasi manual: setiap file wajib ada (upload baru ATAU sudah tersimpan di DB)
        $dokumenPenetapan = [
            'tapan_surat_permohonan',
            'tapan_surat_selesai_harmon',
            'tapan_ba_harmon',
            'tapan_softcopy_harmon',
            'tapan_draft_akhir',
        ];
        foreach ($dokumenPenetapan as $field) {
            if (!$regulasi->$field && !$request->hasFile($field)) {
                return back()
                    ->withErrors([$field => 'File ini wajib diupload.'])
                    ->withInput();
            }
        }

        $data = $request->only(['tgl_mulai_penetapan', 'tgl_selesai_penetapan', 'catatan_penetapan']);

        foreach ($dokumenPenetapan as $field) {
            if ($request->hasFile($field)) {
                if ($regulasi->$field)
                    Storage::disk('public')->delete($regulasi->$field);
                $data[$field] = $request->file($field)->store('penetapan-dokumen', 'public');
            }
        }

        $regulasi->update($data);

        // Majukan ke tahap penetapan jika masih di harmonisasi
        if ($regulasi->current_stage === 'harmonisasi') {
            $regulasi->tahapans()
                ->where('stage', 'harmonisasi')
                ->whereNull('completed_at')
                ->update(['status' => 'completed', 'completed_at' => now()]);

            $regulasi->update(['current_stage' => 'penetapan', 'status' => 'penetapan']);

            RegulasiTahapan::create([
                'regulasi_id' => $regulasi->id,
                'stage' => 'penetapan',
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        }

        // Tandai selesai jika tanggal selesai penetapan sudah diisi
        if ($request->filled('tgl_selesai_penetapan')) {
            $regulasi->update(['status' => 'selesai']);
            $regulasi->tahapans()
                ->where('stage', 'penetapan')
                ->whereNull('completed_at')
                ->update(['status' => 'completed', 'completed_at' => now()]);
        }

        return redirect()->route('regulasi.show', $regulasi)
            ->with('success', 'Data penetapan diperbarui.')
            ->withFragment('tahap-penetapan');
    }

    /**
     * Pastikan user hanya bisa akses regulasi unit kerjanya sendiri.
     * Super admin dikecualikan supaya bisa lihat semua regulasi untuk approval.
     */
    private function authorizeUnitKerja(Regulasi $regulasi): void
    {
        $user = auth()->user();

        if ($user->role === 'super_admin') {
            return;
        }

        if ($regulasi->unit_kerja !== $user->unit_kerja) {
            abort(403, 'Anda tidak memiliki akses ke regulasi ini.');
        }
    }

    private function authorizeSuperAdmin(): void
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Hanya Super Admin yang bisa melakukan tindakan ini.');
        }
    }
}