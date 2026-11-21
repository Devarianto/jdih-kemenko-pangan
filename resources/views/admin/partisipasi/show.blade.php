@extends('layouts.app')

@section('page-title', 'Kelola Partisipasi Publik & Moderasi Masukan')

@section('content')

    @php
        $allTanggapan = $regulasi->tanggapan->sortByDesc('created_at');
        $countTotal = $allTanggapan->count();
        $countMenunggu = $allTanggapan->where('status_tindak_lanjut', 'menunggu')->count();
        $countDitelaah = $allTanggapan->where('status_tindak_lanjut', 'ditelaah')->count();
        $countDiterima = $allTanggapan->where('status_tindak_lanjut', 'diterima')->count();
        $countDitolak = $allTanggapan->where('status_tindak_lanjut', 'ditolak')->count();
        $countHidden = $allTanggapan->where('is_hidden', true)->count();
    @endphp

    <div class="partisipasi-wrap">

        {{-- TOP ACTION BAR --}}
        <div class="top-action-bar">
            <a href="{{ route('admin.partisipasi.index') }}" class="btn btn-outline" style="font-size: 12.5px; padding: 8px 14px;">
                ← Kembali ke Daftar
            </a>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('regulasi.show', $regulasi->id) }}" class="btn btn-outline" style="font-size: 12.5px; padding: 8px 14px;">
                    📋 Detail Penyusunan Regulasi
                </a>
                @if($regulasi->partisipasiPublik)
                    <a href="{{ route('partisipasi-publik.show', $regulasi->partisipasiPublik->id) }}" target="_blank" class="btn btn-outline" style="font-size: 12.5px; padding: 8px 14px; border-color: #0f766e; color: #0f766e;">
                        ↗ Lihat di Halaman Publik
                    </a>
                @endif
                <a href="{{ route('admin.partisipasi.export-csv', $regulasi->id) }}" class="btn btn-primary" style="font-size: 12.5px; padding: 8px 15px; background: #15803d;">
                    ⬇ Ekspor Laporan Masukan (CSV)
                </a>
            </div>
        </div>

        {{-- INFO REGULASI --}}
        <div class="card info-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; flex-wrap: wrap;">
                <div class="info-jenis">{{ $regulasi->jenis }}</div>
                @if($regulasi->partisipasiPublik?->is_active)
                    <span class="badge badge-penetapan">🟢 Konsultasi Publik Aktif</span>
                @else
                    <span class="badge badge-draft">🔒 Konsultasi Publik Tidak Aktif / Selesai</span>
                @endif
            </div>
            <h2 class="info-judul">{{ $regulasi->judul }}</h2>
            <div class="info-meta">
                <span>🏛️ Unit Pemrakarsa: <strong>{{ $regulasi->unit_kerja }}</strong></span>
                <span>📅 Diusulkan: <strong>{{ $regulasi->tgl_usulan?->format('d M Y') }}</strong></span>
                @if($regulasi->file_draft)
                    <span>📄 <a href="{{ Storage::url($regulasi->file_draft) }}" target="_blank" style="color:#003580; font-weight:600;">Lihat Dokumen Draf PDF ↗</a></span>
                @endif
            </div>
        </div>

        {{-- RINGKASAN STATISTIK MASUKAN --}}
        <div class="mod-stats-row">
            <div class="mod-stat-box">
                <div class="mod-stat-label">Total Masukan</div>
                <div class="mod-stat-val">{{ $countTotal }}</div>
            </div>
            <div class="mod-stat-box" style="border-left-color: #64748b;">
                <div class="mod-stat-label">Menunggu Telaah</div>
                <div class="mod-stat-val">{{ $countMenunggu }}</div>
            </div>
            <div class="mod-stat-box" style="border-left-color: #2563eb;">
                <div class="mod-stat-label">Sedang Ditelaah</div>
                <div class="mod-stat-val">{{ $countDitelaah }}</div>
            </div>
            <div class="mod-stat-box" style="border-left-color: #16a34a;">
                <div class="mod-stat-label">Diterima / Diakomodasi</div>
                <div class="mod-stat-val">{{ $countDiterima }}</div>
            </div>
            <div class="mod-stat-box" style="border-left-color: #dc2626;">
                <div class="mod-stat-label">Ditolak / Disembunyikan</div>
                <div class="mod-stat-val">{{ $countDitolak + $countHidden }}</div>
            </div>
        </div>

        {{-- SET UJI PUBLIK --}}
        <div class="form-card set-uji-publik-card">
            <div class="form-section-title">⚙️ Pengaturan Periode Konsultasi / Partisipasi Publik</div>
            <form action="{{ route('admin.partisipasi.set', $regulasi->id) }}" method="POST">
                @csrf
                <div class="date-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai *</label>
                        <input type="date" name="tgl_mulai" class="form-control" required
                            value="{{ $regulasi->partisipasiPublik?->tgl_mulai }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai *</label>
                        <input type="date" name="tgl_selesai" class="form-control" required
                            value="{{ $regulasi->partisipasiPublik?->tgl_selesai }}">
                    </div>
                </div>
                <div class="form-submit-row">
                    <button type="submit" class="btn btn-primary">Simpan & Aktifkan Partisipasi Publik</button>
                </div>
            </form>

            @if($regulasi->partisipasiPublik?->is_active)
                <div class="action-row">
                    <div class="action-note">
                        Periode partisipasi publik sedang berjalan. Selesaikan jika masukan masyarakat sudah cukup dan regulasi siap lanjut ke tahap Pasca Partisipasi Publik / Harmonisasi.
                    </div>
                    <form action="{{ route('admin.partisipasi.selesaikan', $regulasi->id) }}" method="POST" class="js-confirm"
                        data-confirm-icon="✔" data-confirm-title="Selesaikan Partisipasi Publik?"
                        data-confirm-text="Regulasi akan lanjut ke tahap berikutnya dan publik tidak bisa lagi mengirim tanggapan baru."
                        data-confirm-ok="Ya, Selesaikan" data-confirm-tone="success">
                        @csrf
                        <button type="submit" class="btn-selesaikan">✓ Selesaikan Partisipasi Publik</button>
                    </form>
                </div>
            @endif

            @if(auth()->user()->role === 'super_admin' && $regulasi->partisipasiPublik?->is_active)
                <div class="action-row">
                    <div class="action-note">
                        ⚠️ Hentikan sementara (Takedown) apabila terdapat kendala pada dokumen draf atau pengaturan jadwal.
                    </div>
                    <form action="{{ route('admin.partisipasi.takedown', $regulasi->id) }}" method="POST" class="js-confirm"
                        data-confirm-icon="🛑" data-confirm-title="Takedown Periode Uji Publik?"
                        data-confirm-text="Periode partisipasi publik akan dinonaktifkan dari halaman publik." data-confirm-ok="Ya, Takedown"
                        data-confirm-tone="danger">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-takedown">🛑 Takedown</button>
                    </form>
                </div>
            @endif
        </div>

        {{-- KHUSUS SUPER ADMIN: SESUAIKAN JUMLAH MASUKAN YANG TAMPIL DI HALAMAN PUBLIK --}}
        @if(auth()->user()->role === 'super_admin')
            @php
                $realVisibleMasukan = $allTanggapan->where('is_hidden', false)->count();
                $masukanTambahan = (int) ($regulasi->partisipasiPublik->masukan_tambahan ?? 0);
                $displayedMasukan = $regulasi->partisipasiPublik
                    ? $regulasi->partisipasiPublik->displayMasukanCount($realVisibleMasukan)
                    : $realVisibleMasukan;
            @endphp
            <div class="form-card" style="border-left: 4px solid #0d47a1;">
                <div class="form-section-title" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                    <span>💬 Penyesuaian Jumlah Masukan Halaman Publik <span style="font-size: 11px; font-weight: 700; color: #0d47a1; background: #e8f0fe; padding: 2px 8px; border-radius: 999px; margin-left: 6px;">Khusus Super Admin</span></span>
                </div>
                <p style="font-size: 13px; color: #475569; margin: 6px 0 14px; line-height: 1.5;">
                    Atur jumlah masukan yang ditampilkan pada badge <strong>"Masukan Publik"</strong> di halaman publik Partisipasi Publik (misal untuk menambahkan masukan offline/surat/rapat).
                    Saat ini tercatat <strong>{{ $realVisibleMasukan }}</strong> masukan online aktif{{ $masukanTambahan !== 0 ? ' (penyesuaian: ' . ($masukanTambahan > 0 ? '+' . $masukanTambahan : $masukanTambahan) . ')' : '' }}.
                </p>

                <form action="{{ route('admin.partisipasi.adjust-masukan', $regulasi->id) }}" method="POST"
                    style="display: flex; align-items: flex-end; gap: 12px; flex-wrap: wrap;">
                    @csrf
                    <div class="form-group" style="margin-bottom: 0; min-width: 210px;">
                        <label class="form-label">Jumlah Tampil di Publik *</label>
                        <input type="number" name="target_masukan" id="inputTargetMasukan" min="0" max="1000000"
                            class="form-control" value="{{ old('target_masukan', $displayedMasukan) }}" required
                            style="font-weight: 700; color: #0f172a;">
                    </div>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap; align-items: center;">
                        <button type="button" class="btn btn-outline" style="font-size: 12px; padding: 8px 11px;"
                            onclick="var el=document.getElementById('inputTargetMasukan'); el.value=Math.max(0, (parseInt(el.value||0,10)+1));">+1</button>
                        <button type="button" class="btn btn-outline" style="font-size: 12px; padding: 8px 11px;"
                            onclick="var el=document.getElementById('inputTargetMasukan'); el.value=Math.max(0, (parseInt(el.value||0,10)+5));">+5</button>
                        <button type="button" class="btn btn-outline" style="font-size: 12px; padding: 8px 11px;"
                            onclick="var el=document.getElementById('inputTargetMasukan'); el.value=Math.max(0, (parseInt(el.value||0,10)+10));">+10</button>
                        <button type="submit" class="btn btn-primary" style="font-size: 13px; padding: 9px 18px;">
                            Simpan Jumlah Tampil
                        </button>
                    </div>
                </form>

                @if($masukanTambahan !== 0)
                    <form action="{{ route('admin.partisipasi.adjust-masukan', $regulasi->id) }}" method="POST" style="margin-top: 10px;">
                        @csrf
                        <input type="hidden" name="reset" value="1">
                        <button type="submit" class="btn btn-outline" style="font-size: 12px; padding: 6px 12px; color: #b91c1c; border-color: #fecaca; background: #fef2f2;">
                            ↺ Reset ke Jumlah Asli ({{ $realVisibleMasukan }})
                        </button>
                    </form>
                @endif
            </div>
        @endif

        {{-- DAFTAR TANGGAPAN & MODERASI --}}
        <div class="card">
            <div class="tanggapan-toolbar">
                <div class="card-title" style="margin-bottom: 0;">📨 Daftar Tanggapan & Masukan Publik ({{ $countTotal }})</div>
                <div class="tanggapan-filters">
                    <input type="text" id="filterSearchTanggapan" class="form-control" placeholder="Cari pengirim / isi masukan..." style="width: 220px; padding: 7px 12px; font-size: 12.5px;">
                    <select id="filterStatusTanggapan" class="form-control" style="width: auto; padding: 7px 12px; font-size: 12.5px;">
                        <option value="">Semua Status Telaah</option>
                        <option value="menunggu">Menunggu Telaah</option>
                        <option value="ditelaah">Sedang Ditelaah</option>
                        <option value="diterima">Masukan Diterima / Diakomodasi</option>
                        <option value="ditolak">Tidak Diakomodasi</option>
                    </select>
                </div>
            </div>

            @forelse($allTanggapan as $tanggapan)
                @php
                    $statusKey = $tanggapan->status_tindak_lanjut ?? 'menunggu';
                    $senderName = $tanggapan->nama_pengirim ?? $tanggapan->user?->name ?? 'Anonim';
                @endphp
                <div class="tanggapan-item {{ $tanggapan->is_hidden ? 'tanggapan-hidden' : '' }}"
                     data-status="{{ $statusKey }}"
                     data-search="{{ strtolower($senderName . ' ' . $tanggapan->nama_instansi . ' ' . $tanggapan->email . ' ' . $tanggapan->isi_tanggapan) }}">

                    <div class="tanggapan-header">
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <span class="tanggapan-nama">{{ $senderName }}</span>
                                <span class="badge {{ $tanggapan->tipe === 'masyarakat' ? 'badge-proses' : 'badge-publik' }}">
                                    {{ $tanggapan->tipe === 'masyarakat' ? 'Masyarakat Umum' : 'Pemerintahan / Akademisi' }}
                                </span>
                                <span class="mod-status-badge status-{{ $statusKey }}">
                                    {{ $tanggapan->label_status }}
                                </span>
                                @if($tanggapan->is_hidden)
                                    <span class="badge-hidden">Disembunyikan dari Publik</span>
                                @endif
                            </div>

                            {{-- DETAIL KONTAK PENGIRIM (HANYA TAMPIL DI ADMIN) --}}
                            <div class="sender-contact-row">
                                @if($tanggapan->nama_instansi)
                                    <span>🏛️ <strong>{{ $tanggapan->nama_instansi }}</strong></span>
                                @endif
                                @if($tanggapan->email)
                                    <span>✉️ {{ $tanggapan->email }}</span>
                                @endif
                                @if($tanggapan->nomor_telepon)
                                    <span>📞 {{ $tanggapan->nomor_telepon }}</span>
                                @endif
                                <span>🕒 {{ $tanggapan->created_at->format('d M Y H:i') }} ({{ $tanggapan->created_at->diffForHumans() }})</span>
                            </div>
                        </div>

                        <div class="tanggapan-meta">
                            <button type="button" class="btn-mod-toggle" onclick="toggleModerationPanel('mod-panel-{{ $tanggapan->id }}')">
                                ✏️ Telaah & Tindak Lanjut
                            </button>

                            <form action="{{ route('admin.tanggapan.hide', $tanggapan->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-icon-action"
                                    title="{{ $tanggapan->is_hidden ? 'Tampilkan kembali ke publik' : 'Sembunyikan dari halaman publik' }}">
                                    {{ $tanggapan->is_hidden ? '👁️' : '⃠' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.tanggapan.destroy', $tanggapan->id) }}" method="POST"
                                style="display:inline;" class="js-confirm" data-confirm-icon="🗑️"
                                data-confirm-title="Hapus Tanggapan?"
                                data-confirm-text="Tindakan ini tidak bisa dibatalkan. Data tanggapan yang dihapus tidak dapat dikembalikan."
                                data-confirm-ok="Ya, Hapus" data-confirm-tone="danger">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon-action btn-icon-danger" title="Hapus tanggapan">🗑️</button>
                            </form>
                        </div>
                    </div>

                    <div class="tanggapan-isi">{{ $tanggapan->isi_tanggapan }}</div>

                    {{-- RINGKASAN TINDAK LANJUT & CATATAN INTERNAL SAAT INI --}}
                    @if($tanggapan->tindak_lanjut || $tanggapan->catatan_internal)
                        <div class="mod-summary-boxes">
                            @if($tanggapan->tindak_lanjut)
                                <div class="mod-summary-public">
                                    <strong>📢 Tindak Lanjut Tim Penyusun (Ditampilkan ke Publik):</strong>
                                    <div>{{ $tanggapan->tindak_lanjut }}</div>
                                </div>
                            @endif
                            @if($tanggapan->catatan_internal)
                                <div class="mod-summary-internal">
                                    <strong>🔒 Catatan Internal Verifikator (Rahasia Internal — Tidak Tampil di Publik):</strong>
                                    <div>{{ $tanggapan->catatan_internal }}</div>
                                </div>
                            @endif
                            @if($tanggapan->reviewed_at)
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">
                                    Terakhir diperbarui oleh <strong>{{ $tanggapan->reviewer?->name ?? 'Admin' }}</strong> pada {{ $tanggapan->reviewed_at->format('d M Y H:i') }}
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- FORM MODERASI & TINDAK LANJUT --}}
                    <div id="mod-panel-{{ $tanggapan->id }}" class="mod-form-panel" style="display: none;">
                        <form action="{{ route('admin.tanggapan.moderation', $tanggapan->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label class="form-label" style="font-size: 12.5px;">Status Telaah & Tindak Lanjut *</label>
                                <select name="status_tindak_lanjut" class="form-control" style="font-size: 13px; padding: 8px 12px;" required>
                                    <option value="menunggu" {{ $statusKey === 'menunggu' ? 'selected' : '' }}>Menunggu Telaah</option>
                                    <option value="ditelaah" {{ $statusKey === 'ditelaah' ? 'selected' : '' }}>Sedang Ditelaah</option>
                                    <option value="diterima" {{ $statusKey === 'diterima' ? 'selected' : '' }}>Masukan Diterima / Diakomodasi</option>
                                    <option value="ditolak" {{ $statusKey === 'ditolak' ? 'selected' : '' }}>Tidak Diakomodasi</option>
                                </select>
                            </div>

                            <div class="date-grid" style="margin-bottom: 12px;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 12.5px;">
                                        📢 Tanggapan / Tindak Lanjut Publik
                                        <span style="font-weight: 400; color: #64748b;">(Tampil di halaman publik)</span>
                                    </label>
                                    <textarea name="tindak_lanjut" rows="3" class="form-control" style="font-size: 13px;"
                                        placeholder="Tuliskan penjelasan tindak lanjut atas masukan ini untuk ditampilkan kepada publik...">{{ $tanggapan->tindak_lanjut }}</textarea>
                                </div>

                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" style="font-size: 12.5px; color: #9a3412;">
                                        🔒 Catatan Internal Tim Penyusun
                                        <span style="font-weight: 400; color: #b45309;">(Hanya untuk Admin)</span>
                                    </label>
                                    <textarea name="catatan_internal" rows="3" class="form-control" style="font-size: 13px; background: #fffbeb; border-color: #fde68a;"
                                        placeholder="Catatan disposisi atau pertimbangan internal (tidak pernah ditampilkan ke publik)...">{{ $tanggapan->catatan_internal }}</textarea>
                                </div>
                            </div>

                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <button type="button" class="btn btn-outline" style="padding: 7px 14px; font-size: 12.5px;" onclick="toggleModerationPanel('mod-panel-{{ $tanggapan->id }}')">Batal</button>
                                <button type="submit" class="btn btn-primary" style="padding: 7px 16px; font-size: 12.5px;">Simpan Telaah & Tindak Lanjut</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #94a3b8; padding: 32px 16px;">Belum ada tanggapan publik yang masuk untuk rancangan regulasi ini.</p>
            @endforelse
        </div>

    </div>

    {{-- Modal konfirmasi --}}
    <div class="confirm-modal-overlay" id="confirmModalOverlay">
        <div class="confirm-modal">
            <div class="confirm-modal-icon" id="confirmModalIcon">❓</div>
            <div class="confirm-modal-title" id="confirmModalTitle">Konfirmasi</div>
            <div class="confirm-modal-text" id="confirmModalText">Yakin ingin melanjutkan?</div>
            <div class="confirm-modal-actions">
                <button type="button" class="confirm-modal-cancel" id="confirmModalCancel">Batal</button>
                <button type="button" class="confirm-modal-ok" id="confirmModalOk">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <style>
        .partisipasi-wrap {
            max-width: 980px;
            width: 100%;
            margin: 0 auto;
        }

        .top-action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .info-card {
            margin-bottom: 18px;
        }

        .info-jenis {
            font-size: 11px;
            color: #003580;
            background: #eaf0ff;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .info-judul {
            font-size: 18px;
            font-weight: 700;
            color: #0d1b3e;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .info-meta {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            font-size: 13px;
            color: #475569;
        }

        .mod-stats-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .mod-stat-box {
            background: #ffffff;
            border: 1px solid #e4eaf6;
            border-left: 4px solid #002060;
            border-radius: 10px;
            padding: 14px 16px;
        }

        .mod-stat-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
        }

        .mod-stat-val {
            font-size: 24px;
            font-weight: 700;
            color: #0d1b3e;
            margin-top: 4px;
        }

        .set-uji-publik-card {
            margin-bottom: 20px;
        }

        .date-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-submit-row {
            text-align: right;
            margin-top: 8px;
        }

        .action-row {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .action-note {
            font-size: 12.5px;
            color: #64748b;
            flex: 1 1 260px;
        }

        .btn-selesaikan {
            background: #1a7a4c;
            color: #fff;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
        }

        .tanggapan-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid #eef1f8;
        }

        .tanggapan-filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tanggapan-item {
            padding: 18px;
            border: 1px solid #e8edf6;
            border-radius: 12px;
            margin-bottom: 14px;
            background: #ffffff;
        }

        .tanggapan-hidden {
            background: #fffbeb;
            border-color: #fde68a;
        }

        .tanggapan-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .tanggapan-nama {
            font-weight: 700;
            font-size: 14px;
            color: #0d1b3e;
        }

        .sender-contact-row {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
        }

        .tanggapan-meta {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .tanggapan-isi {
            font-size: 13.5px;
            color: #334155;
            line-height: 1.65;
            white-space: pre-line;
            background: #f8fafc;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #edf2f7;
        }

        .mod-status-badge {
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .status-menunggu { background: #f1f5f9; color: #475569; }
        .status-ditelaah { background: #dbeafe; color: #1d4ed8; }
        .status-diterima { background: #dcfce7; color: #15803d; }
        .status-ditolak { background: #fee2e2; color: #b91c1c; }

        .btn-mod-toggle {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            padding: 5px 11px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-mod-toggle:hover {
            background: #dbeafe;
        }

        .mod-summary-boxes {
            margin-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mod-summary-public {
            padding: 10px 14px;
            background: #f0f9ff;
            border-left: 3px solid #0284c7;
            border-radius: 6px;
            font-size: 12.5px;
            color: #0f172a;
        }

        .mod-summary-internal {
            padding: 10px 14px;
            background: #fffbeb;
            border-left: 3px solid #d97706;
            border-radius: 6px;
            font-size: 12.5px;
            color: #78350f;
        }

        .mod-form-panel {
            margin-top: 14px;
            padding: 16px;
            background: #f8faff;
            border: 1px solid #dbe6f8;
            border-radius: 10px;
        }

        .btn-icon-action {
            background: none;
            border: 1px solid #e6e8f0;
            border-radius: 6px;
            width: 30px;
            height: 30px;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .badge-hidden {
            font-size: 10.5px;
            font-weight: 700;
            color: #9a3412;
            background: #ffedd5;
            border: 1px solid #fed7aa;
            border-radius: 12px;
            padding: 2px 8px;
        }

        /* ── Modal konfirmasi ── */
        .confirm-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(13, 20, 40, 0.55);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .confirm-modal-overlay.active {
            display: flex;
        }

        .confirm-modal {
            background: #fff;
            border-radius: 16px;
            padding: 28px 26px 24px;
            max-width: 340px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 50px rgba(10, 15, 30, 0.25);
        }

        .confirm-modal-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            margin: 0 auto 14px;
        }

        .confirm-modal-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .confirm-modal-text {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
            margin-bottom: 22px;
        }

        .confirm-modal-actions {
            display: flex;
            gap: 10px;
        }

        .confirm-modal-actions button {
            flex: 1;
            padding: 10px 14px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .confirm-modal-cancel { background: #f1f2f6; color: #374151; }
        .confirm-modal-ok { background: #003580; color: #fff; }
        .confirm-modal-ok.tone-danger { background: #a32626; }
        .confirm-modal-ok.tone-success { background: #1a7a4c; }

        @media (max-width: 768px) {
            .mod-stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
            .date-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        function toggleModerationPanel(id) {
            var panel = document.getElementById(id);
            if (!panel) return;
            panel.style.display = (panel.style.display === 'none' || !panel.style.display) ? 'block' : 'none';
        }

        (function () {
            var searchInput = document.getElementById('filterSearchTanggapan');
            var statusSelect = document.getElementById('filterStatusTanggapan');
            var items = document.querySelectorAll('.tanggapan-item');

            function filterItems() {
                var q = (searchInput ? searchInput.value : '').toLowerCase().trim();
                var st = statusSelect ? statusSelect.value : '';
                items.forEach(function (el) {
                    var matchQ = !q || (el.getAttribute('data-search') || '').includes(q);
                    var matchSt = !st || el.getAttribute('data-status') === st;
                    el.style.display = (matchQ && matchSt) ? '' : 'none';
                });
            }

            if (searchInput) searchInput.addEventListener('input', filterItems);
            if (statusSelect) statusSelect.addEventListener('change', filterItems);

            let pendingForm = null;
            const overlay = document.getElementById('confirmModalOverlay');
            const btnOk = document.getElementById('confirmModalOk');
            const btnCancel = document.getElementById('confirmModalCancel');
            const modalIcon = document.getElementById('confirmModalIcon');
            const modalTitle = document.getElementById('confirmModalTitle');
            const modalText = document.getElementById('confirmModalText');

            document.querySelectorAll('form.js-confirm').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    pendingForm = form;
                    modalIcon.textContent = form.dataset.confirmIcon || '❓';
                    modalTitle.textContent = form.dataset.confirmTitle || 'Konfirmasi';
                    modalText.textContent = form.dataset.confirmText || 'Yakin ingin melanjutkan?';
                    btnOk.textContent = form.dataset.confirmOk || 'Ya, Lanjutkan';
                    const tone = form.dataset.confirmTone || '';
                    btnOk.className = 'confirm-modal-ok' + (tone ? ' tone-' + tone : '');
                    overlay.classList.add('active');
                });
            });

            btnOk.addEventListener('click', function () {
                overlay.classList.remove('active');
                if (pendingForm) pendingForm.submit();
            });

            function closeModal() {
                overlay.classList.remove('active');
                pendingForm = null;
            }

            btnCancel.addEventListener('click', closeModal);
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeModal();
            });
        })();
    </script>

@endsection
