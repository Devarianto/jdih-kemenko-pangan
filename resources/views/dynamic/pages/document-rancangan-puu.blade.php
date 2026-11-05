@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper">
      <div class="middle__search">
        <form action="">
          <div class="row">
            <div class="column column-65">
              <label for="">{{ lang::translate('document.search-naskah.title') }}</label>
              <input type="text" name="search" value="{{ request()->query('search') }}" placeholder="Cari judul rancangan peraturan...">
            </div>
            <div class="column column-20">
              <label for="">{{ lang::translate('document.search-naskah.form-title.year') }}</label>
              <select name="year" id="">
                <option value="" disabled selected>{{ lang::translate('document.search-naskah.form-placeholder.year') }}</option>
                @foreach ($years as $data)
                <option value="{{ $data->year }}" @selected($data->year == request()->query('year'))>{{ $data->year }}</option>
                @endforeach
              </select>
            </div>
            <div class="column column-15">
              <button type="submit" class="button-icon button-gradient">
                {{ lang::translate('document.search-naskah.button') }}
                <i class="wa-icon wa-ic-search-outline"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="listing-rules">
        @forelse($documents as $document)
          <div class="listing-rules__item" style="border-radius: 8px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <figure><img src="{{ media::initial($document->thumbnail)->url }}" alt="{{ media::initial($document->thumbnail)->alt }}"></figure>
            <figcaption>
              <div class="wrap-flex" style="align-items: flex-start;">
                <div class="text" style="width: 100%;">
                  <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 6px;">
                    <span class="category" style="background-color: #0d47a1; color: #fff; font-weight: 600; padding: 3px 10px; border-radius: 4px; font-size: 11px;">
                      {{ $document->stage_label ?? ($document->tahapan ? $document->tahapan->name : 'Dalam Proses Pembentukan') }}
                    </span>
                    <span style="font-size: 12px; color: #64748b;">
                      <i class="wa-icon wa-ic-calendar-outline" style="vertical-align: middle;"></i> {{ date2string($document->date ?: $document->created_at) }}
                    </span>
                  </div>

                  <p style="font-size: 16px; font-weight: 700; color: #0f172a; line-height: 1.4; margin-bottom: 6px;">
                    {{ $document->translated('title') }}
                  </p>

                  <div style="font-size: 13px; color: #1e3a8a; font-weight: 600; margin-bottom: 8px;">
                    🏛️ Unit Pengusul: {{ $document->translated('unit_pemrakarsa') ?: ($document->unit_pemrakarsa ?: 'Kementerian Koordinator Bidang Pangan') }}
                  </div>

                  @if($document->translated('intro'))
                    <div style="font-size: 13px; color: #334155; line-height: 1.5; background: #f8fafc; border-left: 3px solid #2563eb; padding: 8px 12px; border-radius: 4px; margin-bottom: 10px;">
                      <strong style="color: #0f172a; font-size: 12px;">Keterangan / Abstrak Rancangan:</strong><br>
                      {{ Str::limit($document->translated('intro'), 280) }}
                    </div>
                  @endif
                </div>
              </div>

              <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px;">
                <a href="{{ url($document->permalink_document) }}" class="button button-outline" style="padding: 6px 14px; font-size: 13px;">
                  {{ lang::translate('document.read-more') }}
                </a>

                @if($document->regulasi && $document->regulasi->partisipasiPublik)
                  <a href="{{ route('partisipasi-publik.show', $document->regulasi->partisipasiPublik->id) }}" class="button button-gradient" style="padding: 6px 14px; font-size: 13px; background: linear-gradient(135deg, #0d47a1 0%, #1976d2 100%); color: #fff;">
                    💬 Sampaikan Masukan Publik
                  </a>
                @endif
              </div>

              <div class="bottom" style="margin-top: 14px; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                <div class="bottom__left">
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                  @if (!is_null($document->pdf))
                  <small class="downloaded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6663 10.6663V13.333C14.6663 14.0694 14.0694 14.6663 13.333 14.6663H2.66634C1.92996 14.6663 1.33301 14.0694 1.33301 13.333V10.6663H2.66634V13.333H13.333V10.6663H14.6663ZM8.66634 8.3902L10.8616 6.19494L11.8044 7.13775L7.99967 10.9425L4.19494 7.13775L5.13775 6.19494L7.33301 8.3902V1.33301H8.66634V8.3902Z" fill="#999999"/>
                    </svg>
                    {{ lang::translate('document.count.pdf', ['count' => $document->download_pdf_count]) }}
                  </small>
                  @endif
                </div>
                @if (!is_null($document->pdf))
                <div class="bottom__right">
                  <a href="{{ route('document.download', ['type' => 'pdf', 'id' => $document->id]) }}?token={{ Str::random(15) }}" class="button button-outline button-icon" target="__BLANK" style="padding: 4px 10px; font-size: 12px;">
                    {{ lang::translate('document.download.pdf') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6663 10.6663V13.333C14.6663 14.0694 14.0694 14.6663 13.333 14.6663H2.66634C1.92996 14.6663 1.33301 14.0694 1.33301 13.333V10.6663H2.66634V13.333H13.333V10.6663H14.6663ZM8.66634 8.3902L10.8616 6.19494L11.8044 7.13775L7.99967 10.9425L4.19494 7.13775L5.13775 6.19494L7.33301 8.3902V1.33301H8.66634V8.3902Z" fill="#2063D2"/>
                    </svg>
                  </a>
                </div>
                @endif
              </div>
            </figcaption>
          </div>
        @empty
          <h4 style="text-align: center; margin: 0 auto; font-weight:300;">{{ lang::translate('global.search-not-found') }}</h4>
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
  @endpush
@endsection
