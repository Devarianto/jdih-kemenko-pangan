@extends('dynamic.layouts.layout')

@section('content')
  <section class="detail-pages no-banner">
    <div class="wrapper-content">
      <div class="wrap-result">
        <div class="detail-pages--top">
          <a href="{{ $menu->permalink }}" class="back">{{ lang::translate('kamus-hukum.back-to-kamus') }}</a>
          <div class="medsos">
            <label for="">{{ lang::translate('kamus-hukum.share') }}</label>
            <div class="wrap">
              <a href="javascript:;" data-url="{{ url()->current() }}" onclick="navigator.clipboard.writeText(this.dataset.url).then(()=>{ alert('{{ lang::translate('global.url-copy') }}'); });"><img src="{{ asset('images/material/ic-link.svg') }}" alt=""></a>
              <a href="{{ $kamus->share('wa') }}" target="__BLANK"><img src="{{ asset('images/material/ic-wa.svg') }}" alt=""></a>
              <a href="{{ $kamus->share('tw') }}" target="__BLANK"><img src="{{ asset('images/material/ic-x.svg') }}" alt=""></a>
              <a href="{{ $kamus->share('fb') }}" target="__BLANK"><img src="{{ asset('images/material/ic-fb.svg') }}" alt=""></a>
            </div>
          </div>
        </div>  
        <div class="result-kamus">
          <div class="result-kamus__item">
            <h3>{{ $kamus->translated('title') }}</h3>
            <p>{!! $kamus->translated('description') !!}</p>
          </div>
        </div>    
      </div>
      @if (!widget($kamus->id, 'information-kamus-hukum', 'reference')->isEmpty())
      <div class="referensi">
        <h6>{{ lang::translate('kamus-hukum.reference') }}</h6>
        @foreach (widget($kamus->id, 'information-kamus-hukum', 'reference') as $data)
        <a href="{{ $data->translated('link') }}" target="{{ $data->target }}">{{ $data->translated('title') }}</a>
        @endforeach
      </div>
      @endif
    </div>

  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> --}}
  @endpush
@endsection
