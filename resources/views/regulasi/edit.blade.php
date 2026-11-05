@extends('layouts.app')

@section('page-title', 'Edit Pengajuan Regulasi')

@section('content')

    <div style="max-width: 900px;">

        <h2
            style="font-size: 20px; font-weight: 700; color: #333; margin-bottom: 24px; border-bottom: 2px solid #1a5c45; padding-bottom: 10px;">
            Edit Pengajuan Regulasi
        </h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('regulasi.update', $regulasi) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- INFORMASI REGULASI --}}
            <div class="form-card">
                <div class="form-section-title">Informasi Regulasi</div>

                <div class="form-group">
                    <label class="form-label">Jenis Peraturan *</label>
                    <select name="jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Undang Undang Dasar" {{ old('jenis', $regulasi->jenis) == 'Undang Undang Dasar' ? 'selected' : '' }}>
                            Undang Undang Dasar</option>
                        <option value="Ketetapan MPR" {{ old('jenis', $regulasi->jenis) == 'Ketetapan MPR' ? 'selected' : '' }}>Ketetapan MPR
                        </option>
                        <option value="Undang-Undang" {{ old('jenis', $regulasi->jenis) == 'Undang-Undang' ? 'selected' : '' }}>Undang-Undang
                        </option>
                        <option value="Peraturan Pemerintah Pengganti Undang-Undang" {{ old('jenis', $regulasi->jenis) == 'Peraturan Pemerintah Pengganti Undang-Undang' ? 'selected' : '' }}>Peraturan
                            Pemerintah Pengganti Undang-Undang
                        </option>
                        <option value="Peraturan Pemerintah" {{ old('jenis', $regulasi->jenis) == 'Peraturan Pemerintah' ? 'selected' : '' }}>
                            Peraturan Pemerintah</option>
                        <option value="Peraturan Presiden" {{ old('jenis', $regulasi->jenis) == 'Peraturan Presiden' ? 'selected' : '' }}>
                            Peraturan Presiden</option>
                        <option value="Intruksi Presiden" {{ old('jenis', $regulasi->jenis) == 'Intruksi Presiden' ? 'selected' : '' }}>Intruksi
                            Presiden</option>
                        <option value="Peraturan Menteri" {{ old('jenis', $regulasi->jenis) == 'Peraturan Menteri' ? 'selected' : '' }}>
                            Peraturan Menteri</option>
                        <option value="Keputusan Menteri" {{ old('jenis', $regulasi->jenis) == 'Keputusan Menteri' ? 'selected' : '' }}>
                            Keputusan Menteri</option>
                        <option value="Intruksi Menteri" {{ old('jenis', $regulasi->jenis) == 'Intruksi Menteri' ? 'selected' : '' }}>Intruksi
                            Menteri</option>
                        <option value="Surat Edaran" {{ old('jenis', $regulasi->jenis) == 'Surat Edaran' ? 'selected' : '' }}>
                            Surat Edaran
                        </option>
                        <option value="Peraturan Badan" {{ old('jenis', $regulasi->jenis) == 'Peraturan Badan' ? 'selected' : '' }}>Peraturan
                            Badan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Judul Rancangan Regulasi *</label>
                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Perlindungan Pangan Lokal..."
                        value="{{ old('judul', $regulasi->judul) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Usulan *</label>
                    <input type="date" name="tgl_usulan" class="form-control"
                        value="{{ old('tgl_usulan', $regulasi->tgl_usulan?->format('Y-m-d')) }}" required>
                </div>
            </div>

            {{-- DOKUMEN PENDUKUNG --}}
            <div class="form-card">
                <div class="form-section-title">Dokumen Pendukung</div>

                <div class="form-group">
                    <label class="form-label">
                        Dokumen Permohonan (Surat/Nota Dinas)
                        @if(!$regulasi->file_permohonan) * @endif
                    </label>
                    @if($regulasi->file_permohonan)
                        <div class="file-info" style="margin-bottom: 8px;">
                            📄 File saat ini: <a href="{{ Storage::url($regulasi->file_permohonan) }}" target="_blank">Lihat /
                                Unduh</a>
                        </div>
                    @endif
                    <label class="upload-btn" style="position:relative; display:inline-block; overflow:hidden;">
                        📁 {{ $regulasi->file_permohonan ? 'Ganti File Permohonan (opsional)' : 'Pilih File Permohonan' }}
                        <input type="file" name="file_permohonan" id="filePermohonan" accept=".pdf"
                            @if(!$regulasi->file_permohonan) required @endif
                            style="position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer; margin:0; padding:0;"
                            onchange="handleFileChange(this, 'namaPermohonan')">
                    </label>
                    <div class="file-info" id="namaPermohonan">Belum ada file baru dipilih</div>
                    <small style="color: #888; font-size: 12px;">
                        Format: PDF · Maksimal 1 MB
                        @if($regulasi->file_permohonan)
                            · Biarkan kosong jika tidak ingin mengganti file yang sudah diupload.
                        @endif
                    </small>
                    @error('file_permohonan')
                        <small class="file-error" style="display:block; color:#c0392b; font-size:12px; margin-top:4px;">⚠
                            {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Draft Awal Rancangan
                        @if(!$regulasi->file_draft) * @else (Opsional) @endif
                    </label>
                    @if($regulasi->file_draft)
                        <div class="file-info" style="margin-bottom: 8px;">
                            📄 File saat ini: <a href="{{ Storage::url($regulasi->file_draft) }}" target="_blank">Lihat /
                                Unduh</a>
                        </div>
                    @endif
                    <label class="upload-btn" style="position:relative; display:inline-block; overflow:hidden;">
                        📁 {{ $regulasi->file_draft ? 'Ganti File Draft (opsional)' : 'Pilih File Draft' }}
                        <input type="file" name="file_draft" id="fileDraft" accept=".pdf,.doc,.docx"
                            @if(!$regulasi->file_draft) required @endif
                            style="position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer; margin:0; padding:0;"
                            onchange="handleFileChange(this, 'namaDraft')">
                    </label>
                    <div class="file-info" id="namaDraft">Belum ada file baru dipilih</div>
                    <small style="color: #888; font-size: 12px;">
                        Format: PDF, DOC, DOCX · Maksimal 1 MB
                        @if($regulasi->file_draft)
                            · Biarkan kosong jika tidak ingin mengganti file yang sudah diupload.
                        @endif
                    </small>
                    @error('file_draft')
                        <small class="file-error" style="display:block; color:#c0392b; font-size:12px; margin-top:4px;">⚠
                            {{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- INFORMASI PEMOHON --}}
            <div class="form-card">
                <div class="form-section-title">Informasi Pemohon</div>

                <div class="form-group">
                    <label class="form-label">Unit Kerja Pemohon/Pemrakarsa (Eselon II) *</label>
                    <select name="unit_kerja_display" class="form-control" disabled>
                        <option>{{ $regulasi->unit_kerja }}</option>
                    </select>
                    <small style="color: #888; font-size: 12px;">Unit kerja tidak dapat diubah.</small>
                </div>

                <div style="text-align: right;">
                    <a href="{{ route('regulasi.show', $regulasi) }}" class="btn"
                        style="margin-right: 8px; padding: 12px 20px; font-size: 14px;">Batal</a>
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px;">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </div>

        </form>
    </div>

    <script>
        const MAX_FILE_SIZE = 1024 * 1024; // 1 MB

        // Update nama file terpilih + tandai kalau lewat 1MB
        function handleFileChange(input, infoId) {
            const infoEl = document.getElementById(infoId);
            const file = input.files[0];

            if (!file) {
                infoEl.textContent = 'Belum ada file baru dipilih';
                infoEl.style.color = '';
                return;
            }

            if (file.size > MAX_FILE_SIZE) {
                const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                infoEl.textContent = `⚠ ${file.name} (${sizeMb} MB) melebihi batas maksimal 1 MB`;
                infoEl.style.color = '#c0392b';
                input.value = ''; // reset supaya tidak ikut ter-submit
            } else {
                infoEl.textContent = file.name;
                infoEl.style.color = '';
            }
        }

        // Guard tambahan saat submit: cegah kalau file baru yang dipilih ternyata lewat 1MB
        document.querySelector('form').addEventListener('submit', function (e) {
            const fileInputs = [
                { input: document.getElementById('filePermohonan'), infoId: 'namaPermohonan' },
                { input: document.getElementById('fileDraft'), infoId: 'namaDraft' },
            ];

            let hasError = false;

            fileInputs.forEach(({ input, infoId }) => {
                const infoEl = document.getElementById(infoId);
                const file = input.files[0];

                if (file && file.size > MAX_FILE_SIZE) {
                    const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                    infoEl.textContent = `⚠ ${file.name} (${sizeMb} MB) melebihi batas maksimal 1 MB`;
                    infoEl.style.color = '#c0392b';
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault();
            }
        });
    </script>

@endsection