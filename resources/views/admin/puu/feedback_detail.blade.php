@extends('cactuar::admin.layout-master')

@section('content')
<div class="mb-3">
    <a href="{{ url()->admin('puu-partisipasi-publik/feedback?unique=' . $feedback->document_id) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Masukan
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-1">Rincian Masukan Masyarakat</h4>
                <p class="text-muted mb-0"><strong>Dokumen Terkait:</strong> {{ $feedback->document->title ?? '-' }}</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;" class="table-light">Nama Pengirim</th>
                        <td>{{ $feedback->name }}</td>
                    </tr>
                    <tr>
                        <th class="table-light">Email</th>
                        <td><a href="mailto:{{ $feedback->email }}">{{ $feedback->email }}</a></td>
                    </tr>
                    <tr>
                        <th class="table-light">Nomor Telepon / WA</th>
                        <td>{{ $feedback->phone ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="table-light">Instansi / Lembaga</th>
                        <td>{{ $feedback->institution ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="table-light">Profesi / Jabatan</th>
                        <td>{{ $feedback->profession ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="table-light">Kota / Daerah</th>
                        <td>{{ $feedback->city ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="table-light">Waktu Pengiriman</th>
                        <td>{{ $feedback->created_at ? $feedback->created_at->format('d F Y, H:i:s') : '-' }}</td>
                    </tr>
                    <tr>
                        <th class="table-light">Alamat IP / Browser</th>
                        <td><small class="text-muted">{{ $feedback->ip_address }} ({{ $feedback->user_agent }})</small></td>
                    </tr>
                    <tr>
                        <th class="table-light">Lampiran Pendukung</th>
                        <td>
                            @if ($feedback->file_attachment)
                                <a href="{{ asset('storage/' . $feedback->file_attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-paperclip"></i> Unduh Berkas Lampiran
                                </a>
                            @else
                                <span class="text-muted">Tidak ada lampiran berkas.</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="mt-4">
                    <h5>Isi Masukan / Tanggapan:</h5>
                    <div class="p-3 bg-light rounded border" style="white-space: pre-line; line-height: 1.7;">
                        {{ $feedback->feedback }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Verifikasi & Status Masukan</h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="post" action="{{ url()->admin('puu-partisipasi-publik/feedback-status') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $feedback->id }}">

                    <div class="mb-3">
                        <label class="form-label">Status Saat Ini</label>
                        <select name="status" class="form-control" required>
                            <option value="pending" {{ $feedback->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Verifikasi)</option>
                            <option value="reviewed" {{ $feedback->status == 'reviewed' ? 'selected' : '' }}>Reviewed (Sedang Ditinjau)</option>
                            <option value="approved" {{ $feedback->status == 'approved' ? 'selected' : '' }}>Approved (Diterima / Sah)</option>
                            <option value="rejected" {{ $feedback->status == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak / Spam)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Tim Hukum (Internal)</label>
                        <textarea name="notes" rows="4" class="form-control" placeholder="Tuliskan catatan disposisi atau telaah masukan...">{{ $feedback->notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa fa-save"></i> Perbarui Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
