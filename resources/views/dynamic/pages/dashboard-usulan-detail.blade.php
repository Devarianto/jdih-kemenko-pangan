@extends('static.layouts.layout')

@section('content')
  <section class="dashboard">
    <div class="wrapper">
      @include('dynamic.component.dashboard-left', ['active' => 'usulan'])
      <div class="dashboard__right">
        <div class="dashboard__right--title">
          <a href="{{ route('dashboard') }}" class="back">
            Kembali
          </a>
        </div>
        <div class="box-white table">
          <h5>DETAIL USULAN PROJECT</h5>
          <table>
            <tr>
              <td>Nomor Project</td>
              <td>{{ $project->no_project }}</td>
            </tr>
             <tr>
              <td>Judul</td>
              <td>{{ $project->name_project }}</td>
            </tr>
            <tr>
              <td>Kategori</td>
              <td>{{ optional($project->category)->label }}</td>
            </tr>
            <tr>
              <td>Tanggal Ulasan</td>
              <td>{{ \Carbon\Carbon::parse($project->date)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
              <td>Lampiran</td>
              <td>
                @php
                  $files = [];
                  if (is_string($project->file)) {
                    $decoded = json_decode($project->file, true);
                    $files = is_array($decoded) ? $decoded : (empty($project->file) ? [] : [$project->file]);
                  }
                @endphp
                @if(count($files) === 0)
                -
                @else
                  @foreach($files as $path)
                    <div><a href="{{ asset('storage/'.$path) }}" target="_blank">{{ basename($path) }}</a></div>
                  @endforeach
                @endif
              </td>
            </tr>
          </table>
          <hr>
          <h5>INFORMASI PEMOHON</h5>
          <table>
            <tr>
              <td>Divisi/Pemohon</td>
              <td>
                @if($project->applicantDivisions && $project->applicantDivisions->count())
                  {{ $project->applicantDivisions->pluck('label')->join(', ') }}
                @else
                  -
                @endif
              </td>
            </tr>
            <tr>
              <td>Nama Pemohon</td>
              <td>{{ $project->applicant_name }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/dashboard.scss')}}" preload>
  @endpush
  @push('footer')
    <!-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> -->
  @endpush
@endsection
