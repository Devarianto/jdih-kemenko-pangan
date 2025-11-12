@extends('dynamic.layouts.layout')

@section('content')
  <section class="dashboard">
    <div class="wrapper">
      @include('dynamic.component.dashboard-left', ['active' => 'project'])
      <div class="dashboard__right">
        <div class="dashboard__right--title">
          <h5>{{lang::translate('dashboard.daftar-project.title-page')}}</h5>
        </div>
        <div class="box-white search">
          <form method="GET" action="{{ route('project') }}">
            <div class="row">
              <div class="column column-50">
                <label for="">{{lang::translate('dashboard.form-filter.label-name-project')}}</label>
                <input type="text" name="q" placeholder="{{lang::translate('dashboard.form-filter.placeholder-name-project')}}" value="{{ request('q') }}">
              </div>
              <div class="column column-35">
                <label for="">{{lang::translate('dashboard.form-filter.label-year')}}</label>
                <select name="year" id="">
                  <option value="">{{lang::translate('dashboard.form-filter.placeholder-year')}}</option>
                  @if(isset($years))
                  @foreach($years as $y)
                  <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                  @endforeach
                  @endif
                </select>
              </div>
              <div class="column column-15">
                <button type="submit" class="button-gradient button-icon button-large">
                   {{lang::translate('dashboard.form-filter.button-search')}}
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
          <h5>{{lang::translate('dashboard.daftar-project.list-table.daftar-project')}}</h5>
          <div class="content-pages">
            <div class="table-content">
              <table>
                <thead>
                  <tr>
                    <th>{{lang::translate('dashboard.daftar-project.list-table.no')}}</th>
                    <th>{{lang::translate('dashboard.daftar-project.list-table.nomor-project')}}</th>
                    <th>{{lang::translate('dashboard.daftar-project.list-table.nama-project')}}</th>
                    <th>{{lang::translate('dashboard.daftar-project.list-table.kategori')}}</th>
                    <th>{{lang::translate('dashboard.daftar-project.list-table.tanggal-usulan')}}</th>
                    <th>{{lang::translate('dashboard.daftar-project.list-table.tanggal-penyelesain')}}</th>
                    <th>{{lang::translate('dashboard.daftar-project.list-table.status')}}</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($projects as $project)
                  <tr>
                    <td>{{ ($projects->currentPage() - 1) * $projects->perPage() + $loop->iteration }}</td>
                    <td>{{ $project->no_project }}</td>
                    <td>{{ $project->name_project }}</td>
                    <td>{{ optional($project->category)->label }}</td>
                    <td>{{ \Carbon\Carbon::parse($project->date)->translatedFormat('d F Y') }}</td>
                    <td>-</td>
                    <td>
                      <span class="status {{ optional($project->getStatus)->color }}">{{ optional($project->getStatus)->label ?? '-' }}</span>
                    </td>
                    <td><a href="{{ route('detail.project', ['id' => Crypt::encryptString($project->id)]) }}" class="button button-outline">{{lang::translate('dashboard.daftar-project.list-table.detail')}}</a></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="8" style="text-align:center;">{{lang::translate('dashboard.daftar-project.list-table.belum-ada-data')}}</td>
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
