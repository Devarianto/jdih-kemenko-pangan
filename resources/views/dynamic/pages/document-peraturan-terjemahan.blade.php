@extends('dynamic.layouts.layout')

@section('content')
  @php
    $hasWidgetBanner = isset($menu->id) && widget($menu->id, 'menu', 'banner')->isNotEmpty();
  @endphp

  @if($hasWidgetBanner)
    @include('dynamic.component.banner')
  @else
    <section class="banner-middle">
      <figure>
        <img src="{{ asset('assets/thumbs/images/banner/cover_1440_400_banner-peraturan-new.jpg.webp') }}" 
             alt="{{ lang::active() == 'en' ? 'Translated Regulations' : 'Peraturan Terjemahan' }}"
             onerror="this.src='/images/material/banner-default.jpg';">
      </figure>
      <figcaption>
        <small>{{ lang::active() == 'en' ? 'LEGAL DOCUMENTS' : 'DOKUMEN HUKUM' }}</small>
        <h2>{{ lang::active() == 'en' ? 'Translated Regulations' : 'Peraturan Terjemahan' }}</h2>
      </figcaption>
      <div class="wave">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="140" viewBox="0 180 2500 200" fill="#F8F8F8" preserveAspectRatio="none">
          <path class="st1" d="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250">
            <animate attributeName="d" dur="5s"
              values="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250;
                      M 0 250 C 400 100 400 320 3000 250 L 3000 550 L 0 550 L 0 250;
                      M 0 250 C 1200 280 1200 100 3000 250 L 3000 550 L 0 550 L 0 250"
              repeatCount="indefinite" />
          </path>
        </svg>
      </div>
    </section>
  @endif

  <section class="middle">
    <div class="wrapper">
      <div class="middle__search">
        <form action="{{ url()->current() }}" method="GET">
          <div class="row">
            <div class="column column-45">
              <label for="search-input">{{ lang::active() == 'en' ? 'Search Keyword' : 'Kata Kunci Pencarian' }}</label>
              <input type="text" id="search-input" name="search" value="{{ request()->query('search') }}" 
                     placeholder="{{ lang::active() == 'en' ? 'Search English title, regulation number, or topic...' : 'Cari judul Bahasa Inggris, nomor, atau topik...' }}">
            </div>
            <div class="column column-25">
              <label for="rule-type-select">{{ lang::active() == 'en' ? 'Regulation Type' : 'Jenis Peraturan' }}</label>
              <select name="rule_type" id="rule-type-select">
                <option value="">{{ lang::active() == 'en' ? 'All Types' : 'Semua Jenis' }}</option>
                @foreach ($rule_types as $data)
                  <option value="{{ $data->id }}" @selected($data->id == request()->query('rule_type'))>{{ $data->label }}</option>
                @endforeach
              </select>
            </div>
            <div class="column column-15">
              <label for="year-select">{{ lang::active() == 'en' ? 'Year' : 'Tahun' }}</label>
              <select name="year" id="year-select">
                <option value="">{{ lang::active() == 'en' ? 'All Years' : 'Semua Tahun' }}</option>
                @foreach ($years as $data)
                  <option value="{{ $data->year }}" @selected($data->year == request()->query('year'))>{{ $data->year }}</option>
                @endforeach
              </select>
            </div>
            <div class="column column-15">
              <button type="submit" class="button-icon button-gradient" style="margin-top: 24px; width: 100%;">
                {{ lang::active() == 'en' ? 'Search' : 'Cari' }}
                <i class="wa-icon wa-ic-search-outline"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="listing-rules">
        @forelse($documents as $document)
          <div class="listing-rules__item">
            <figure>
              <img src="{{ media::initial($document->thumbnail)->url }}" 
                   alt="{{ $document->translation_title ?: $document->translated('title') }}"
                   onerror="this.src='/images/material/document-placeholder.png';">
            </figure>
            <figcaption>
              <div class="wrap-flex">
                <div class="text">
                  <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap; margin-bottom: 6px;">
                    <span class="category" @if (!$document->status_berlaku) style="background-color: #C25A5A;" @endif>
                      {{ $document->front_status_berlaku }}
                    </span>
                    <span class="category" style="background-color: #002060; color: #ffffff; font-weight: 600;">
                      <i class="fa fa-language"></i> English Version
                    </span>
                    @if(!empty($document->rule_type))
                      <span class="category" style="background-color: #0c8599; color: #ffffff;">
                        {{ $document->rule_type->label }}
                      </span>
                    @endif
                  </div>

                  @if(!empty($document->no_peraturan) || !empty($document->translation_no_peraturan))
                    <div style="font-size: 13px; font-weight: 700; color: #002060; margin-bottom: 4px;">
                      {{ $document->translation_no_peraturan ?: $document->no_peraturan }} &middot; Tahun {{ $document->year }}
                    </div>
                  @endif

                  <h3 style="font-size: 17px; font-weight: 700; color: #1e293b; margin: 4px 0 6px 0; line-height: 1.45;">
                    {{ $document->translation_title ?: $document->translated('title') }}
                  </h3>

                  @if(!empty($document->translation_title) && $document->translated('title') && $document->translation_title !== $document->translated('title'))
                    <small style="color: #64748b; font-size: 12.5px; display: block; margin-bottom: 6px; font-style: italic;">
                      <strong>Judul Asli (ID):</strong> {{ $document->translated('title') }}
                    </small>
                  @endif

                  <small style="color: #475569; font-size: 13px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $document->translation_intro ?: $document->translated('intro') }}
                  </small>
                </div>

                <a href="{{ $document->customPermalink('document-peraturan') ?: url('/peraturan-hukum') }}" 
                   class="button button-outline" style="white-space: nowrap; align-self: flex-start;">
                  {{ lang::translate('document.read-more') }}
                </a>
              </div>

              <div class="bottom">
                <div class="bottom__left">
                  <small class="visited" title="Dilihat {{ $document->view_count }} kali">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ lang::translate('document.count.view', ['count' => $document->view_count]) }}
                  </small>
                  @if (!empty($document->pdf) || !empty($document->translation_pdf))
                    <small class="downloaded" title="Diunduh {{ $document->download_pdf_count }} kali">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6663 10.6663V13.333C14.6663 14.0694 14.0694 14.6663 13.333 14.6663H2.66634C1.92996 14.6663 1.33301 14.0694 1.33301 13.333V10.6663H2.66634V13.333H13.333V10.6663H14.6663ZM8.66634 8.3902L10.8616 6.19494L11.8044 7.13775L7.99967 10.9425L4.19494 7.13775L5.13775 6.19494L7.33301 8.3902V1.33301H8.66634V8.3902Z" fill="#999999"/>
                      </svg>
                      {{ lang::translate('document.count.pdf', ['count' => $document->download_pdf_count]) }}
                    </small>
                  @endif
                </div>

                <div class="bottom__right" style="display: flex; gap: 8px; flex-wrap: wrap;">
                  @if (!empty($document->translation_pdf))
                    <a href="{{ route('document.download', ['type' => 'translation_pdf', 'id' => $document->id]) }}?token={{ Str::random(15) }}" 
                       class="button button-outline button-icon" 
                       target="_blank" 
                       style="background: #eef2ff; color: #1e40af; border-color: #bfdbfe;"
                       title="Download English Version PDF">
                      <span>Download PDF (EN)</span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6663 10.6663V13.333C14.6663 14.0694 14.0694 14.6663 13.333 14.6663H2.66634C1.92996 14.6663 1.33301 14.0694 1.33301 13.333V10.6663H2.66634V13.333H13.333V10.6663H14.6663ZM8.66634 8.3902L10.8616 6.19494L11.8044 7.13775L7.99967 10.9425L4.19494 7.13775L5.13775 6.19494L7.33301 8.3902V1.33301H8.66634V8.3902Z" fill="#1e40af"/>
                      </svg>
                    </a>
                  @endif

                  @if (!empty($document->pdf))
                    <a href="{{ route('document.download', ['type' => 'pdf', 'id' => $document->id]) }}?token={{ Str::random(15) }}" 
                       class="button button-outline button-icon" 
                       target="_blank"
                       title="Download Original PDF">
                      <span>{{ lang::translate('document.download.pdf') }}</span>
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
          <div style="text-align: center; padding: 48px 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; margin: 20px 0;">
            <i class="fa fa-folder-open" style="font-size: 38px; color: #94a3b8; margin-bottom: 12px; display: block;"></i>
            <h4 style="font-size: 16px; font-weight: 600; color: #475569; margin-bottom: 6px;">
              {{ lang::active() == 'en' ? 'No translated regulations found.' : 'Belum ada peraturan terjemahan yang ditemukan.' }}
            </h4>
            <p style="font-size: 13px; color: #64748b; max-width: 480px; margin: 0 auto;">
              {{ lang::active() == 'en' ? 'Regulations with English translation will appear here once translated versions are published.' : 'Peraturan hukum dengan terjemahan Bahasa Inggris akan ditampilkan di sini setelah versi terjemahan diunggah melalui Admin Panel.' }}
            </p>
          </div>
        @endforelse
      </div>

      {{ $documents->appends(request()->query())->links('dynamic.component.pagination') }}
    </div>
  </section>
  
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
@endsection
