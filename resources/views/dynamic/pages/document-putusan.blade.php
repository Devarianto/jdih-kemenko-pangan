@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper">
      <div class="middle__search">
        <form action="">
          <div class="row">
            <div class="column column-65">
              <label for="">{{ lang::translate('document.search-putusan.title') }}</label>
              <input type="text" name="search" value="{{ request()->query('search') }}" placeholder="{{ lang::translate('document.search-putusan.placeholder') }}">
            </div>
            <div class="column column-20">
              <label for="">{{ lang::translate('document.search-putusan.form-title.year') }}</label>
              <select name="year" id="">
                <option value="" disabled selected>{{ lang::translate('document.search-putusan.form-placeholder.year') }}</option>
                @foreach ($years as $data)
                <option value="{{ $data->year }}" @selected($data->year == request()->query('year'))>{{ $data->year }}</option>
                @endforeach
              </select>
            </div>
            <div class="column column-15">
              <button type="submit" class="button-icon button-gradient">
                {{ lang::translate('document.search-putusan.button') }}
                <i class="wa-icon wa-ic-search-outline"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="filter-right">
        <form action="">
          <div class="col">
            <label for="">{{ lang::translate('global.sorting.title') }}</label>
            <select name="sort" id="">
              <option value="latest" @selected(request()->query('sort') == 'latest')>{{ lang::translate('global.sorting.latest') }}</option>
              <option value="oldest" @selected(request()->query('sort') == 'oldest')>{{ lang::translate('global.sorting.oldest') }}</option>
            </select>
          </div>
        </form>
      </div>
      <div class="listing-rules without-bottom">
        @foreach($documents as $document)
          <a href="{{ $document->customPermalink('document-putusan') }}" class="listing-rules__item">
            <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
            <figcaption>
              <div class="wrap-flex">
                <div class="text">
                  <span class="category" @if (!$document->status_berlaku) style="background-color: #C25A5A;" @endif>{{ $document->front_status_berlaku }}</span>
                  <span class="tag">{{ $document->jenis_peradilan }}</span>
                  <p>{{ $document->translated('title') }}</p>
                </div>
                <span class="button button-outline">{{ lang::translate('document.read-more') }}</span>
              </div>
              <div class="bottom">
                <div class="bottom__left">
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                </div>
              </div>
            </figcaption>
          </a>
        @endforeach
      </div>
      {{ $documents->appends(request()->query())->links('dynamic.component.pagination') }}
    </div>
  </section>
  
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        function sort(){
          const sort = document.querySelector('select[name="sort"]').value;

          const baseUrl = window.location.origin + window.location.pathname;
          const params = new URLSearchParams();

          if (sort) params.append('sort', sort);

          window.location.href = baseUrl + '?' + params.toString();
        }

        document.querySelector('select[name="sort"]').addEventListener('change', function() {
          sort();
        });
      });
    </script>
  @endpush
@endsection
