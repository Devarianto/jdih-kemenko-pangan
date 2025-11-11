@extends('dynamic.layouts.layout')

@section('content')
  <section class="dashboard">
    <div class="wrapper">
      @include('dynamic.component.dashboard-left', ['active' => 'usulan'])
      <div class="dashboard__right">
        <div class="dashboard__right--title">
          <h5>Usulan Project</h5>
          <a href="{{ route('form.usulan') }}" class="button button-outline button-icon">
            Buat Usulan Project
          </a>
        </div>
        <div class="box-white search">
          <form method="GET" action="{{ route('dashboard') }}">
            <div class="row">
              <div class="column column-50">
                <label for="">Nama Project</label>
                <input type="text" name="q" placeholder="Ketik Kata Kunci Pencarian" value="{{ request('q') }}">
              </div>
              <div class="column column-35">
                <label for="">Tahun</label>
                <select name="year" id="">
                  <option value="">Pilih Tahun</option>
                  @if(isset($years))
                  @foreach($years as $y)
                  <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                  @endforeach
                  @endif
                </select>
              </div>
              <div class="column column-15">
                <button type="submit" class="button-gradient button-icon button-large">
                  Cari
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M7.33333 12.6667C10.2789 12.6667 12.6667 10.2789 12.6667 7.33333C12.6667 4.38781 10.2789 2 7.33333 2C4.38781 2 2 4.38781 2 7.33333C2 10.2789 4.38781 12.6667 7.33333 12.6667Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.0992 13.7008L11.1992 10.8008" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="box-white with-table">
          <h5>DAFTAR USULAN PROJECT</h5>
          <div class="content-pages">
            <div class="table-content">
              <table>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Project</th>
                    <th>Nama Project</th>
                    <th>Kategori</th>
                    <th>Tanggal Usulan</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($projects as $index => $project)
                  @php
                  $rowNumber = ($projects->currentPage() - 1) * $projects->perPage() + $loop->iteration;
                  $statusMap = [
                    0 => ['label' => 'Review', 'class' => 'review'],
                    1 => ['label' => 'Ditolak', 'class' => 'rejected'],
                  ];
                  $status = $statusMap[$project->status_review] ?? $statusMap[0];
                  @endphp
                  <tr>
                    <td>{{ $rowNumber }}</td>
                    <td>{{ $project->no_project }}</td>
                    <td>{{ $project->name_project }}</td>
                    <td>{{ optional($project->category)->label }}</td>
                    <td>{{ \Carbon\Carbon::parse($project->date)->translatedFormat('d F Y') }}</td>
                    <td><span class="status {{ $status['class'] }}">{{ $status['label'] }}</span></td>
                    <td><a href="{{ route('detail.usulan', ['id' => Crypt::encryptString($project->id)]) }}" class="button button-outline">Detail</a></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="7" style="text-align:center;">Belum ada data</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
 
           {{ $projects->appends(request()->query())->links('dynamic.component.pagination') }}
        </div>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/dashboard.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
  @endpush
@endsection
