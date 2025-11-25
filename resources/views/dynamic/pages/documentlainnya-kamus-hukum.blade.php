@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper">
      <div class="middle__search">
        <form action="">
          <div class="row">
            <div class="column column-85">
              <label for="">{{ lang::translate('kamus-hukum.search.title') }}</label>
              <input type="text" name="search" value="{{ request()->query('search') }}" placeholder="{{ lang::translate('kamus-hukum.search.placeholder') }}">
            </div>
            <div class="column column-15">
              <button type="submit" class="button-icon button-gradient">
                {{ lang::translate('kamus-hukum.search.button') }}
                <i class="wa-icon wa-ic-search-outline"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="search-by-abjad">
        <span class="filter-option all {{ request()->query('option') == 'all' || request()->query('option') == null ? 'active' : '' }}" data-value="all">{{ lang::translate('kamus-hukum.all') }}</span>
        @foreach(range('a', 'z') as $letter)
          <span class="filter-option {{ request()->query('option') == $letter ? 'active' : '' }}" data-value="{{ $letter }}">{{ $letter }}</span>
        @endforeach
      </div>
      <div class="listing-kamus">
        @forelse ($kamus as $data)
          <a href="{{ $data->permalink }}" class="listing-kamus__item">
            <div class="listing-kamus__item--text">
              <h6>{{ $data->translated('title') }}</h6>
              <p>{{ $data->translated('intro') }}</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ lang::translate('document.count.view', ['count' => $data->view_count]) }}
              </small>
            </div>
            <span class="button button-outline">{{ lang::translate('kamus-hukum.read-more') }}</span>
          </a>
        @empty
        @if (request()->query('option'))
          <h4 style="text-align: center; font-weight:300;">{{ lang::translate('kamus-hukum.alphabet-not-found') }}</h4>
        @else
          <h4 style="text-align: center; font-weight:300;">{{ lang::translate('kamus-hukum.data-not-found') }}</h4>
        @endif
        @endforelse
      </div>
      {{ $kamus->appends(request()->query())->links('dynamic.component.pagination') }}
    </div>
  </section>
  
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const spans = document.querySelectorAll('span.filter-option');

        spans.forEach(function(span) {
          span.addEventListener('click', function() {
            const dataValue = span.getAttribute('data-value');

            // Ambil URL saat ini tanpa query
            const baseUrl = window.location.origin + window.location.pathname;
            const params = new URLSearchParams(window.location.search);
            // Tambahkan atau update query param
            params.set('option', dataValue);

            // Redirect ke URL baru dengan query
            window.location.href = `${baseUrl}?${params.toString()}`;
          });
        });
      });
    </script>
  @endpush
@endsection
