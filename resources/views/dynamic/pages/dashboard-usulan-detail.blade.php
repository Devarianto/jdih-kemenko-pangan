@extends('dynamic.layouts.layout')

@section('content')
  <section class="dashboard">
    <div class="wrapper">
      @include('dynamic.component.dashboard-left', ['active' => 'usulan'])
      <div class="dashboard__right">
        <div class="dashboard__right--title">
          <a href="{{ route('dashboard') }}" class="back">
            {{lang::translate('dashboard.kembali')}}
          </a>
        </div>
        <div class="box-white table">
          <h5> {{lang::translate('dashboard.usulan-project.detail.title-page')}} </h5>
          <table>
            <tr>
              <td>{{lang::translate('dashboard.usulan-project.detail.nomor-project')}}</td>
              <td>{{ $project->no_project }}</td>
            </tr>
             <tr>
              <td>{{lang::translate('dashboard.usulan-project.detail.nama-project')}}</td>
              <td>{{ $project->name_project }}</td>
            </tr>
            <tr>
              <td>{{lang::translate('dashboard.usulan-project.detail.kategori-project')}}</td>
              <td>{{ optional($project->category)->label }}</td>
            </tr>
            <tr>
              <td>{{lang::translate('dashboard.usulan-project.detail.tanggal-usulan')}}</td>
              <td>{{ \Carbon\Carbon::parse($project->date)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
              <td>{{lang::translate('dashboard.usulan-project.detail.lampiran')}}</td>
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
                    <div><a href="{{ route('project.download', ['id' => Crypt::encryptString($project->id), 'loop' => $loop->iteration, 'type' => 'detail']) }}" target="_blank">{{ basename($path) }}</a></div>
                  @endforeach
                @endif
              </td>
            </tr>
          </table>
          <hr>
          <h5>{{lang::translate('dashboard.usulan-project.detail.title-pemohon')}}</h5>
          <table>
            <tr>
              <td>{{lang::translate('dashboard.usulan-project.detail.divisi-pemohon')}}</td>
              <td>
                @if($project->applicantDivisions && $project->applicantDivisions->count())
                  {{ $project->applicantDivisions->pluck('label')->join(', ') }}
                @else
                  -
                @endif
              </td>
            </tr>
            <tr>
              <td>{{lang::translate('dashboard.usulan-project.detail.nama-pemohon')}}</td>
              <td>{{ $project->applicant_name }}</td>
            </tr>
          </table>
          <hr>
          <h5>{{lang::translate('dashboard.daftar-project.detail.status-project')}}</h5>
          <div class="status-project">
            @forelse(($updates ?? []) as $key => $u)
            <div class="status-project__step {{ !$loop->last ? '' : 'done' }}">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                  <rect x="2" y="2" width="44" height="44" rx="22" fill="white" stroke="#999999" stroke-width="4"/>
                  <path d="M16.8008 22.6L21.3008 28L31.2008 19" stroke="#999999" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <span class="date">{{ \Carbon\Carbon::parse($u['date'])->translatedFormat('d F Y') }}</span>
              <div class="text">
                <p><b>{{ $u['label'] }}</b></p>
              </div>
            </div>
            @empty
            <div class="status-project__step">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                  <rect x="2" y="2" width="44" height="44" rx="22" fill="white" stroke="#999999" stroke-width="4"/>
                  <path d="M16.8008 22.6L21.3008 28L31.2008 19" stroke="#999999" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <span class="date">-</span>
              <div class="text">
                <p><b>{{lang::translate('dashboard.daftar-project.detail.belum-ada-data')}}</b></p>
              </div>
            </div>
            @endforelse
          </div>
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
