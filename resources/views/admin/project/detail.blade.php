@extends('cactuar::admin.layout-master')

@section('content')
<style>
.timeline {
  position: relative;
  list-style: none;
  padding-left: 1.5rem;
  margin-left: 1rem;
  border-left: 2px dashed #dee2e6;
}

.timeline-item {
  position: relative;
  margin-bottom: 1.5rem;
  padding-left: 1rem;
}

.timeline-item::before {
  content: "";
  position: absolute;
  left: -1.1rem;
  top: 0.3rem;
  width: 10px;
  height: 10px;
  background-color: #0d6efd;
  border-radius: 50%;
}

.timeline-date {
  font-size: 0.85rem;
  color: #6c757d;
}

.timeline-title {
  font-weight: 600;
  margin-bottom: 0.25rem;
}

</style>
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Detail</strong> Usulan Project</h1>

    <div class="row">
        <div class="col-md-12">
            <!-- DETAIL USULAN PROJECT -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">DETAIL USULAN PROJECT</h5>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Nomor Project</div>
                        <div class="col-md-8">: {{$data->no_project}}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Judul</div>
                        <div class="col-md-8">: {{ $data->name_project }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Kategori</div>
                        <div class="col-md-8">: {{ optional($data->category)->label }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Tanggal Ulasan</div>
                        <div class="col-md-8">: {{ \Carbon\Carbon::parse($data->date)->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Lampiran</div>
                        <div class="col-md-8">
                            : 
                        @php
		                  $files = [];
		                  if (is_string($data->file)) {
		                    $decoded = json_decode($data->file, true);
		                    $files = is_array($decoded) ? $decoded : (empty($data->file) ? [] : [$data->file]);
		                  }
		                @endphp
		                @if(count($files) === 0)
		                -
		                @else
		                  @foreach($files as $path)
		                    <div><a href="{{ asset($path) }}" target="_blank">{{ basename($path) }}</a></div>
		                  @endforeach
		                @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- INFORMASI PEMOHON -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">INFORMASI PEMOHON</h5>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Divisi/Pemohon</div>
                        <div class="col-md-8">: 
                        	@if($data->applicantDivisions && $data->applicantDivisions->count())
			                  {{ $data->applicantDivisions->pluck('label')->join(', ') }}
			                @else
			                  -
			                @endif
                       	</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Nama Pemohon</div>
                        <div class="col-md-8">: {{ $data->applicant_name }}</div>
                    </div>


                    <!-- Tombol Approve & Reject -->
                    @if((int) $data->status_review === 0)
                    <div class="mt-4 d-flex gap-2">
                        <form action="{{ url()->admin('usulan-project/approve') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="unique" value="{{ $data->id }}">
                            <button type="submit" class="btn btn-success px-4" onclick="return confirm('Approve usulan ini?')">
                                <i class="align-middle me-1" data-feather="check-circle"></i> Approve
                            </button>
                        </form>
                        <form action="{{ url()->admin('usulan-project/reject') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="unique" value="{{ $data->id }}">
                            <button type="submit" class="btn btn-danger px-4" onclick="return confirm('Reject usulan ini?')">
                                <i class="align-middle me-1" data-feather="x-circle"></i> Reject
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                </div>
            </div>

            @if((int) $data->status_review === 2)
            <!-- STATUS PROJECT -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">STATUS PROJECT</h5>
                    <ul class="timeline">
                        @forelse(($updates ?? []) as $u)
                        <li class="timeline-item">
                            <span class="timeline-date">{{ \Carbon\Carbon::parse($u->created_at)->translatedFormat('d F Y') }}</span>
                            <h6 class="timeline-title">{{ $u->label_status_project_id }}</h6>
                            @if(!empty($u->note))
                                <p class="text-muted mb-1">{{ $u->note }}</p>
                            @endif
                            @if(!empty($u->dokumen))
                                <a href="{{ asset($u->dokumen) }}" target="_blank" class="text-primary text-decoration-none">{{ basename($u->dokumen) }}</a>
                            @endif
                        </li>
                        @empty
                        <li class="timeline-item">
                            <span class="timeline-date">-</span>
                            <h6 class="timeline-title">Belum ada pembaruan status</h6>
                        </li>
                        @endforelse
                    </ul>
		            <!-- TOMBOL UPDATE STATUS -->
		            <div class="mb-4">
		                <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
		                    <i class="align-middle me-1" data-feather="edit-3"></i> Update Status
		                </button>
		            </div>
            	</div>
        	</div>
            @endif
    </div>
</div>

<!-- MODAL UPDATE STATUS -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ url()->admin('usulan-project/update-status') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="updateStatusModalLabel">Update Status Project</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="project_id" value="{{ $data->id }}">
          <div class="mb-3">
            <label for="status_project_id" class="form-label fw-semibold">Status</label>
            <select class="form-select" id="status_project_id" name="status_project_id" required>
              <option value="" disabled selected>Pilih status</option>
              @foreach(($statuses ?? []) as $s)
                <option value="{{ $s->id }}">{{ $s->label }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="file" class="form-label fw-semibold">Lampiran File</label>
            <input type="file" class="form-control" id="file" name="file" accept=".pdf,.docx,.jpg,.png">
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tuliskan keterangan status..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="align-middle me-1" data-feather="save"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
