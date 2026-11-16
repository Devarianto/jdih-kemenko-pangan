@extends('layouts.app')

@section('page-title', 'Menu Pengajuan Regulasi')

@section('content')

    <div style="max-width: 900px;">

        <h2
            style="font-size: 20px; font-weight: 700; color: #333; margin-bottom: 24px; border-bottom: 2px solid #1a5c45; padding-bottom: 10px;">
            Formulir Pengajuan Regulasi
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

        <form action="{{ route('regulasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- INFORMASI REGULASI --}}
            <div class="form-card">
                <div class="form-section-title">Informasi Regulasi</div>

                <div class="form-group">
                    <label class="form-label">Jenis Peraturan *</label>
                    <select name="jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Undang Undang Dasar" {{ old('jenis') == 'Undang Undang Dasar' ? 'selected' : '' }}>
                            Undang Undang Dasar</option>
                        <option value="Ketetapan MPR" {{ old('jenis') == 'Ketetapan MPR' ? 'selected' : '' }}>Ketetapan MPR
                        </option>
                        <option value="Undang-Undang" {{ old('jenis') == 'Undang-Undang' ? 'selected' : '' }}>Undang-Undang
                        </option>
                        <option value="Peraturan Pemerintah Pengganti Undang-Undang" {{ old('jenis') == 'Peraturan Pemerintah Pengganti Undang-Undang' ? 'selected' : '' }}>Peraturan Pemerintah Pengganti Undang-Undang
                        </option>
                        <option value="Peraturan Pemerintah" {{ old('jenis') == 'Peraturan Pemerintah' ? 'selected' : '' }}>
                            Peraturan Pemerintah</option>
                        <option value="Peraturan Presiden" {{ old('jenis') == 'Peraturan Presiden' ? 'selected' : '' }}>
                            Peraturan Presiden</option>
                        <option value="Intruksi Presiden" {{ old('jenis') == 'Intruksi Presiden' ? 'selected' : '' }}>Intruksi
                            Presiden</option>
                        <option value="Peraturan Menteri Koordinator" {{ old('jenis') == 'Peraturan Menteri Koordinator' ? 'selected' : '' }}>
                            Peraturan Menteri Koordinator</option>
                        <option value="Peraturan Menteri" {{ old('jenis') == 'Peraturan Menteri' ? 'selected' : '' }}>
                            Peraturan Menteri</option>
                        <option value="Keputusan Menteri" {{ old('jenis') == 'Keputusan Menteri' ? 'selected' : '' }}>
                            Keputusan Menteri</option>
                        <option value="Intruksi Menteri" {{ old('jenis') == 'Intruksi Menteri' ? 'selected' : '' }}>Intruksi
                            Menteri</option>
                        <option value="Surat Edaran" {{ old('jenis') == 'Surat Edaran' ? 'selected' : '' }}>Surat Edaran
                        </option>
                        <option value="Peraturan Badan" {{ old('jenis') == 'Peraturan Badan' ? 'selected' : '' }}>Peraturan
                            Badan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Judul Rancangan Regulasi *</label>
                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Rancangan Peraturan Menteri Koordinator Bidang Pangan tentang..."
                        value="{{ old('judul') }}" required>
                </div>

                @if(empty(auth()->user()->unit_kerja) || auth()->user()->role === 'super_admin')
                <div class="form-group">
                    <label class="form-label">Unit Kerja Pengusul *</label>
                    <select name="unit_kerja" class="form-control" required>
                        <option value="Biro Hukum dan Kerja Sama" {{ old('unit_kerja') == 'Biro Hukum dan Kerja Sama' ? 'selected' : '' }}>Biro Hukum dan Kerja Sama</option>
                        <option value="Sekretariat Kementerian Koordinator" {{ old('unit_kerja') == 'Sekretariat Kementerian Koordinator' ? 'selected' : '' }}>Sekretariat Kementerian Koordinator</option>
                        <option value="Deputi Bidang Koordinasi Usaha Pangan dan Pertanian" {{ old('unit_kerja') == 'Deputi Bidang Koordinasi Usaha Pangan dan Pertanian' ? 'selected' : '' }}>Deputi Bidang Koordinasi Usaha Pangan dan Pertanian</option>
                        <option value="Deputi Bidang Koordinasi Keterjangkauan dan Keamanan Pangan" {{ old('unit_kerja') == 'Deputi Bidang Koordinasi Keterjangkauan dan Keamanan Pangan' ? 'selected' : '' }}>Deputi Bidang Koordinasi Keterjangkauan dan Keamanan Pangan</option>
                        <option value="Deputi Bidang Koordinasi Sumber Daya Maritim" {{ old('unit_kerja') == 'Deputi Bidang Koordinasi Sumber Daya Maritim' ? 'selected' : '' }}>Deputi Bidang Koordinasi Sumber Daya Maritim</option>
                        <option value="Deputi Bidang Koordinasi Tata Niaga dan Distribusi Pangan" {{ old('unit_kerja') == 'Deputi Bidang Koordinasi Tata Niaga dan Distribusi Pangan' ? 'selected' : '' }}>Deputi Bidang Koordinasi Tata Niaga dan Distribusi Pangan</option>
                        <option value="Inspektorat" {{ old('unit_kerja') == 'Inspektorat' ? 'selected' : '' }}>Inspektorat</option>
                    </select>
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Abstrak / Ringkasan Regulasi *</label>
                    <textarea name="abstrak" id="abstrakField" class="form-control" rows="4" maxlength="2000"
                        placeholder="Tuliskan ringkasan singkat mengenai tujuan dan substansi regulasi ini..."
                        oninput="updateCount(this)" required style="resize: vertical;">{{ old('abstrak') }}</textarea>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:5px;">
                        <small style="color:#888; font-size:12px;">Maksimal 2000 karakter</small>
                        <small id="abstrakCount" style="font-size:12px; color:#8a93a6;">
                            <span id="charUsed">{{ strlen(old('abstrak') ?? '') }}</span>/2000
                        </small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Usulan *</label>
                    <input type="date" name="tgl_usulan" class="form-control" value="{{ old('tgl_usulan') }}" required>
                </div>
            </div>

            {{-- DOKUMEN PENDUKUNG --}}
            <div class="form-card">
                <div class="form-section-title">Dokumen Pendukung</div>

                <div class="form-group">
                    @php $isSuperAdmin = auth()->user()->role === 'super_admin'; @endphp
                    <label class="form-label">Upload Dokumen Permohonan (Surat/Nota Dinas) {{ $isSuperAdmin ? '(Opsional untuk Super Admin)' : '*' }}</label>
                    <label class="upload-btn" style="position:relative; display:inline-block; overflow:hidden;">
                        🗁 Pilih File Permohonan
                        <input type="file" name="file_permohonan" id="filePermohonan" accept=".pdf" @if(!$isSuperAdmin) required @endif
                            style="position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer; margin:0; padding:0;"
                            onchange="handleFileChange(this, 'namaPermohonan')">
                    </label>
                    <div class="file-info" id="namaPermohonan">Belum ada file dipilih</div>
                    <small style="color: #888; font-size: 12px;">Format: PDF · Maksimal 10 MB</small>
                    @error('file_permohonan')
                        <small class="file-error" style="display:block; color:#c0392b; font-size:12px; margin-top:4px;">⚠
                            {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Upload Draft Awal Rancangan *</label>
                    <label class="upload-btn" style="position:relative; display:inline-block; overflow:hidden;">
                        🗁 Pilih File Draft
                        <input type="file" name="file_draft" id="fileDraft" accept=".pdf,.doc,.docx" required
                            style="position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer; margin:0; padding:0;"
                            onchange="handleFileChange(this, 'namaDraft')">
                    </label>
                    <div class="file-info" id="namaDraft">Belum ada file dipilih</div>
                    <small style="color: #888; font-size: 12px;">Format: PDF, DOC, DOCX · Maksimal 1 MB</small>
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
                        <option>{{ auth()->user()->unit_kerja }}</option>
                    </select>
                    <small style="color: #888; font-size: 12px;">Unit kerja diambil otomatis dari akun Anda</small>
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px;">
                        ➤ Ajukan Regulasi
                    </button>
                </div>
            </div>

        </form>
    </div>

    <script>
        function updateCount(el) {
            const used = el.value.length;
            const counter = document.getElementById('charUsed');
            if (counter) {
                counter.textContent = used;
                counter.parentElement.style.color = used >= 190 ? '#c0392b' : (used >= 160 ? '#e67e22' : '#8a93a6');
            }
        }

        // Init count on page load (handles old() value)
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('abstrakField');
            if (el) updateCount(el);
        });

        const MAX_FILE_SIZE = 1024 * 1024; // 1 MB

        // Update file name label + warn immediately if file exceeds 1MB
        function handleFileChange(input, infoId) {
            const infoEl = document.getElementById(infoId);
            const file = input.files[0];

            if (!file) {
                infoEl.textContent = 'Belum ada file dipilih';
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

        // Extra guard: cegah submit form kalau ada field file kosong / lewat 1MB
        document.querySelector('form').addEventListener('submit', function (e) {
            const fileInputs = [
                { input: document.getElementById('filePermohonan'), infoId: 'namaPermohonan', label: 'Dokumen Permohonan' },
                { input: document.getElementById('fileDraft'), infoId: 'namaDraft', label: 'Draft Awal Rancangan' },
            ];

            let hasError = false;

            fileInputs.forEach(({ input, infoId, label }) => {
                const infoEl = document.getElementById(infoId);
                const file = input.files[0];

                if (!file) {
                    infoEl.textContent = `⚠ ${label} wajib diunggah`;
                    infoEl.style.color = '#c0392b';
                    hasError = true;
                } else if (file.size > MAX_FILE_SIZE) {
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