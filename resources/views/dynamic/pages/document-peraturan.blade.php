@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper">
      <div class="middle__search">
        <form action="" id="frm-search">
          <div class="row">
              <div class="column column-85">
                <label for="">{{ lang::translate('document.search-peraturan.title') }}</label>
                <input type="text" name="search" value="{{ request()->query('search') }}" class="search-top" placeholder="{{ lang::translate('document.search-peraturan.placeholder') }}">
              </div>
              <div class="column column-15">
                <button type="submit" class="button-icon button-gradient btn-search">
                  {{ lang::translate('document.search-peraturan.button') }}
                  <i class="wa-icon wa-ic-search-outline"></i>
                </button>
              </div>
          </div>
        </form>
        <div class="wrap-filter">
          <a href="">{{ lang::translate('document.search-peraturan.specific-search.title') }}</a>
          <div class="filter">
            <div class="filter__title">
              <h6>{{ lang::translate('document.search-peraturan.specific-search.title') }}</h6>
              <div class="filter__close"></div>
            </div>
            <form action="" id="frm-specific-search">
              <input type="hidden" name="search" class="hidden-search" value="{{ request()->query('search') }}">
              <div class="row">
                <div class="column column-35">
                  <label for="">{{ lang::translate('document.search-peraturan.specific-search.form-title.rule-type') }}</label>
                  <select name="rule_type" id="">
                    <option value="" selected disabled>{{ lang::translate('document.search-peraturan.specific-search.form-placeholder.rule-type') }}</option>
                    @foreach ($rule_types as $data)
                    <option value="{{ $data->id }}" @selected($data->id == request()->query('rule_type'))>{{ $data->label }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="column column-30">
                  <label for="">{{ lang::translate('document.search-peraturan.specific-search.form-title.theme') }}</label>
                  <select name="theme" id="">
                    <option value="" selected disabled>{{ lang::translate('document.search-peraturan.specific-search.form-placeholder.theme') }}</option>
                    @foreach ($rule_themes as $data)
                    <option value="{{ $data->id }}" @selected($data->id == request()->query('theme'))>{{ $data->label }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="column column-20">
                  <label for="">{{ lang::translate('document.search-peraturan.specific-search.form-title.year') }}</label>
                  <select name="year" id="">
                    <option value="" selected disabled>{{ lang::translate('document.search-peraturan.specific-search.form-placeholder.year') }}</option>
                    @foreach ($years as $data)
                    <option value="{{ $data->year }}" @selected($data->year == request()->query('year'))>{{ $data->year }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="column column-15">
                  <button type="submit" class="button-icon button-gradient btn-specific-search">
                    {{ lang::translate('document.search-peraturan.button') }}
                    <i class="wa-icon wa-ic-search-outline"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="listing-rules">
        @forelse($documents as $document)
          <div class="listing-rules__item">
            <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
            <figcaption>
              <div class="wrap-flex">
                <div class="text">
                  <span class="category" @if (!$document->status_berlaku) style="background-color: #C25A5A;" @endif>{{ $document->front_status_berlaku }}</span>
                  <p>{{ $document->translated('title') }}</p>
                  <small>{{ $document->translated('intro') }}</small>
                </div>
                <a href="{{ $document->customPermalink('document-peraturan') }}" class="button button-outline">{{ lang::translate('document.read-more') }}</a>
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
                  <small class="downloaded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6663 10.6663V13.333C14.6663 14.0694 14.0694 14.6663 13.333 14.6663H2.66634C1.92996 14.6663 1.33301 14.0694 1.33301 13.333V10.6663H2.66634V13.333H13.333V10.6663H14.6663ZM8.66634 8.3902L10.8616 6.19494L11.8044 7.13775L7.99967 10.9425L4.19494 7.13775L5.13775 6.19494L7.33301 8.3902V1.33301H8.66634V8.3902Z" fill="#999999"/>
                    </svg>
                    {{ lang::translate('document.count.pdf', ['count' => $document->download_pdf_count]) }}
                  </small>
                </div>
                <div class="bottom__right">
                  @if(!empty($document->abstract))
                  <a href="{{ route('document.download', ['type' => 'abstract', 'id' => $document->id]) }}?token={{ Str::random(15) }}" target="__BLANK" class="button button-outline button-icon">
                    {{ lang::translate('document.download.abstract') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M9.33366 1.33301H4.00033C3.6467 1.33301 3.30756 1.47348 3.05752 1.72353C2.80747 1.97358 2.66699 2.31272 2.66699 2.66634V13.333C2.66699 13.6866 2.80747 14.0258 3.05752 14.2758C3.30756 14.5259 3.6467 14.6663 4.00033 14.6663H12.0003C12.3539 14.6663 12.6931 14.5259 12.9431 14.2758C13.1932 14.0258 13.3337 13.6866 13.3337 13.333V5.33301L9.33366 1.33301Z" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9.33301 1.33301V5.33301H13.333" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M10.6663 8.66699H5.33301" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M10.6663 11.333H5.33301" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M6.66634 6H5.99967H5.33301" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </a>
                  @endif
                  @if(!empty($document->pdf))
                  <a href="{{ route('document.download', ['type' => 'pdf', 'id' => $document->id]) }}?token={{ Str::random(15) }}" class="button button-outline button-icon" target="__BLANK">
                    {{ lang::translate('document.download.pdf') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6663 10.6663V13.333C14.6663 14.0694 14.0694 14.6663 13.333 14.6663H2.66634C1.92996 14.6663 1.33301 14.0694 1.33301 13.333V10.6663H2.66634V13.333H13.333V10.6663H14.6663ZM8.66634 8.3902L10.8616 6.19494L11.8044 7.13775L7.99967 10.9425L4.19494 7.13775L5.13775 6.19494L7.33301 8.3902V1.33301H8.66634V8.3902Z" fill="#2063D2"/>
                    </svg>
                  </a>
                  @endif
                </div>
              </div>
            </figcaption>
          </div>
        @empty
          <h4 style="text-align: center; font-weight:300;">{{ lang::translate('global.search-not-found') }}</h4>
        @endforelse
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
        document.querySelector('#frm-specific-search').addEventListener('submit', function(e) {
          e.preventDefault();

          const inputValue = document.querySelector('.search-top').value;
          document.querySelector('.hidden-search').value = inputValue;

          this.submit();
        });
      });
    </script>
  @endpush
@endsection
