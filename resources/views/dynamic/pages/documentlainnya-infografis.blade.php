@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper">
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
      <div class="listing-card without-box">
        @foreach ($infografis as $data)
          <a href="{{ $data->permalink }}" class="listing-card__item">
            <figure><img src="{{ media::initial($data->thumbnail)->url }}" alt="{{ media::initial($data->thumbnail)->alt }}"></figure>
            <figcaption>
              <p>{{ $data->translated('title') }}</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ lang::translate('global.view', ['count' => $data->view_count]) }}
              </small>
            </figcaption>
          </a>
        @endforeach

      </div>
      {{ $infografis->appends(request()->query())->links('dynamic.component.pagination') }}
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

          const url = new URL(window.location.href);

          if (sort) url.searchParams.set('sort', sort);

          window.location.href = url.toString();
        }

        document.querySelector('select[name="sort"]').addEventListener('change', function() {
          sort();
        });
      });
    </script>
  @endpush
@endsection
