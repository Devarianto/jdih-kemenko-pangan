@extends('cactuar::admin.layout-master')

@section('content')
<div class="mb-3">
    <a href="{{ url()->admin('puu-partisipasi-publik') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Partisipasi Publik
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-1">Daftar Masukan Masyarakat</h4>
        <p class="text-muted mb-0"><strong>Dokumen:</strong> {{ $document->title }}</p>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr class="table-light">
                        <th style="width: 50px;">No</th>
                        <th>Nama Pengirim</th>
                        <th>Kontak & Instansi</th>
                        <th>Ringkasan Masukan</th>
                        <th>Berkas</th>
                        <th style="width: 140px;">Status</th>
                        <th style="width: 130px;">Waktu Kirim</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($feedbacks as $i => $item)
                        <tr>
                            <td>{{ $feedbacks->firstItem() + $i }}</td>
                            <td>
                                <strong>{{ $item->name }}</strong>
                                @if ($item->profession)
                                    <br><small class="text-muted">{{ $item->profession }}</small>
                                @endif
                            </td>
                            <td>
                                <i class="fa fa-envelope text-muted"></i> {{ $item->email }}<br>
                                @if ($item->phone)
                                    <i class="fa fa-phone text-muted"></i> {{ $item->phone }}<br>
                                @endif
                                @if ($item->institution)
                                    <span class="badge bg-light text-dark border">{{ $item->institution }}</span>
                                @endif
                            </td>
                            <td>
                                {{ \Illuminate\Support\Str::limit($item->feedback, 120) }}
                            </td>
                            <td>
                                @if ($item->file_attachment)
                                    <a href="{{ asset('storage/' . $item->file_attachment) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                        <i class="fa fa-paperclip"></i> Unduh
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'pending' => 'bg-warning text-dark',
                                        'approved' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        'reviewed' => 'bg-info text-white'
                                    ][$item->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }} text-uppercase">{{ $item->status }}</span>
                            </td>
                            <td>
                                <small>{{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}</small>
                            </td>
                            <td>
                                <a href="{{ url()->admin('puu-partisipasi-publik/feedback-detail?unique=' . $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i> Rincian
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada masukan masyarakat yang masuk untuk rancangan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $feedbacks->links() }}
        </div>
    </div>
</div>
@endsection
