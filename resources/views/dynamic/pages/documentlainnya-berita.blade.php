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
      <div class="listing-card col-3 news">
        @foreach($news as $data)
          <a href="{{ $data->permalink }}" class="listing-card__item">
            <figure>
              <img src="{{ media::url($data->thumbnail) }}" alt="{{ media::initial($data->thumbnail)->alt }}">
            </figure>
            <figcaption>
              <span class="date">{{ date2string($data->date) }}</span>
              <p>{{ $data->translated('title') }}</p>
              <span class="link"><b>{{ lang::translate('news.read-more') }}</b></span>
            </figcaption>
          </a>
        @endforeach
      </div>
      {{ $news->appends(request()->query())->links('dynamic.component.pagination') }}
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
